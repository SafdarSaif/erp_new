<?php

namespace App\Http\Controllers;

use App\Models\StudentLedger;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Student;
use App\Models\Accounts\StudentFeeStructure;
use App\Models\MiscellaneousFee;
use App\Models\StudentInvoice;
use App\Models\Theme;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf; // if using barryvdh/laravel-dompdf
use Auth;

use Spatie\Browsershot\Browsershot;





class StudentLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */









    // working
    public function ledger($studentId)
    {
        $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

        // Fetch existing fee structure
        $feeStructures = StudentFeeStructure::where('student_id', $studentId)
            ->orderBy('id')
            ->get();

        // Fetch ledger entries with semester and miscellaneous head
        $ledgerEntries = StudentLedger::leftJoin('student_fee_structures', 'student_ledgers.student_fee_id', '=', 'student_fee_structures.id')
            ->leftJoin('miscellaneous_fees', 'student_ledgers.miscellaneous_id', '=', 'miscellaneous_fees.id')
            ->select(
                'student_ledgers.*',
                'student_fee_structures.semester as semester',
                'miscellaneous_fees.head as misc_head'
            )
            ->where('student_ledgers.student_id', $studentId)
            ->orderBy('student_ledgers.id')
            ->get();

        // Student & course details
        $subCourse  = $student->subCourse;
        $courseName = $subCourse->name ?? '-';
        $mode       = $subCourse->courseMode->name ?? 'Semesters';
        $duration   = $subCourse->duration ?? 0;
        $totalFee   = $student->total_fee ?? 0;

        // --- Semester-wise Fee Calculation ---
        if ($feeStructures->count() > 0) {
            $semesterWiseFees = $feeStructures->map(function ($fee) use ($ledgerEntries) {
                $paid = $ledgerEntries
                    ->where('student_fee_id', $fee->id)
                    ->where('transaction_type', 'credit')
                    ->sum('amount');
                $balance = $fee->amount - $paid - $fee->discount;

                return [
                    'id'       => $fee->id,
                    'semester' => $fee->semester,
                    'amount'   => $fee->amount,
                    'discount'   => $fee->discount,
                    'paid'     => $paid,
                    'balance'  => $balance,
                ];
            });
            // dd($semesterWiseFees);
            $totalFee  = $feeStructures->sum('amount') - $feeStructures->sum('discount');
        } else {
            // Static fee structure if not created
            $feePerSem = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

            $semesterWiseFees = [];
            for ($i = 1; $i <= $duration; $i++) {
                $semesterWiseFees[] = [
                    'id'       => null,
                    'semester' => ($mode === 'Yearly') ? "Year $i" : "Semester $i",
                    'amount'   => $feePerSem,
                    'paid'     => 0,
                    'balance'  => $feePerSem,
                ];
            }
        }

        // --- Total Paid including Miscellaneous Fees ---
        $totalPaid = $ledgerEntries
            ->where('transaction_type', 'credit')
            ->sum('amount'); // ✅ includes semester + miscellaneous payments

        // Fetch invoices (if linked to ledger)
        $invoices = StudentInvoice::whereIn('ledger_id', $ledgerEntries->pluck('id'))->get();

        // --- Miscellaneous Fee ---
        $miscellaneousFee = MiscellaneousFee::where('student_id', $studentId)->get();
        $totalMiscellaneousFee = $miscellaneousFee->sum('amount');

        // Compute Miscellaneous Balances
        $miscellaneousWithBalance = $miscellaneousFee->map(function ($misc) use ($ledgerEntries) {
            $paid = $ledgerEntries
                ->where('miscellaneous_id', $misc->id)
                ->where('transaction_type', 'credit')
                ->sum('amount');

            $balance = $misc->amount - $paid;

            $misc->paid = $paid;
            $misc->balance = $balance;

            return $misc;
        });

        // Update total balance including Miscellaneous Fee
        $balance = ($totalFee + $totalMiscellaneousFee) - $totalPaid;


        return view('accounts.fee.ledger', compact(
            'student',
            'feeStructures',
            'ledgerEntries',
            'invoices',
            'totalFee',
            'totalPaid',
            'balance',
            'courseName',
            'mode',
            'duration',
            'semesterWiseFees',
            'miscellaneousFee',
            'miscellaneousWithBalance',
            'totalMiscellaneousFee'
        ));
    }





    public function confirmFeeStructure(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'semesters'  => 'required|array',
            'amounts'    => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $studentId = $request->student_id;
            $semesters = $request->semesters;
            $amounts   = $request->amounts;
            $discount   = $request->discount;

            // Optional: Delete existing fee structure for this student
            StudentFeeStructure::where('student_id', $studentId)->delete();

            // Loop through each semester and store in DB
            foreach ($semesters as $index => $semester) {
                StudentFeeStructure::create([
                    'student_id' => $studentId,
                    'semester'   => $semester,
                    'amount'     => $amounts[$index],
                    'discount'     => $discount[$index],
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Semester-wise fee structure saved successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }







    public function getSemesterBalance($studentId)
    {
        $student = Student::findOrFail($studentId);

        // Fetch fee structures for this student
        $feeStructures = StudentFeeStructure::where('student_id', $studentId)->get();

        // Fetch ledger entries for this student
        $ledgerEntries = StudentLedger::where('student_id', $studentId)
            ->where('transaction_type', 'credit')
            ->get();

        $semesterBalances = [];

        foreach ($feeStructures as $fee) {
            // Sum of paid amount for this semester
            $paid = $ledgerEntries
                ->where('student_fee_id', $fee->id)
                ->sum('amount');

            $balance = $fee->amount - $paid - $fee->discount;

            $semesterBalances[] = [
                'semester'   => $fee->semester,
                'fee_id'     => $fee->id,
                'total_fee'  => $fee->amount - $fee->discount,
                'paid'       => $paid,
                'balance'    => $balance,
            ];
        }

        return response()->json([
            'student'           => $student,
            'semester_balances' => $semesterBalances,
        ]);
    }




    public function loadPaymentModal($studentId)
    {
        $student = Student::with('feeStructures')->findOrFail($studentId);
        $miscellaneousFee = MiscellaneousFee::where('student_id', $studentId)->get();
        return view('accounts.ledger.create', compact('student', 'miscellaneousFee'));
    }












    public function savePayment(Request $request)
    {

        // dd($request->all());
        try {
            $paymentType = $request->payment_type;

            if ($paymentType === 'student_fee') {
                // Existing student fee payment logic
                $studentId    = $request->student_id;
                $studentFeeId = $request->student_fee_id;
                $amount       = $request->amount;

                $fee = StudentFeeStructure::findOrFail($studentFeeId);
                $paid = StudentLedger::where('student_id', $studentId)
                    ->where('student_fee_id', $studentFeeId)
                    ->where('transaction_type', 'credit')
                    ->sum('amount');

                $balance = $fee->amount - $paid;

                if ($balance <= 0) {
                    return response()->json(['status' => 'error', 'message' => 'This semester is already fully paid.']);
                }

                if ($amount > $balance) {
                    return response()->json(['status' => 'error', 'message' => 'Payment exceeds remaining balance.']);
                }

                $ledger = StudentLedger::create([
                    'student_id'       => $studentId,
                    'student_fee_id'   => $studentFeeId,
                    'transaction_type' => 'credit',
                    'amount'           => $amount,
                    'transaction_date' => $request->transaction_date,
                    'payment_mode'     => $request->payment_mode,
                    'utr_no'           => $request->utr_no,
                    'remarks'          => $request->remarks,
                ]);
            } elseif ($paymentType === 'miscellaneous_fee') {
                // Handle miscellaneous fee payment
                $miscFee = MiscellaneousFee::findOrFail($request->miscellaneous_id);

                $ledger = StudentLedger::create([
                    'student_id'       => $request->student_id,
                    'miscellaneous_id'  => $request->miscellaneous_id, // ✅ Add this line
                    'transaction_type' => 'credit',
                    'amount'           =>  $request->amount,
                    'transaction_date' => $request->transaction_date,
                    'payment_mode'     => $request->payment_mode,
                    'utr_no'           => $request->utr_no,
                    'remarks'          => $request->remarks ?? 'Payment for miscellaneous fee: ' . $miscFee->name,
                ]);
            }

            // Generate invoice for both cases
            StudentInvoice::create([
                'ledger_id'  => $ledger->id,
                'invoice_no' => 'INV-' . strtoupper(Str::random(6)),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Payment recorded successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }














    //Working Fine

    // public function downloadReceipt($id)
    // {
    //     // Get ledger and student with related data
    //     $ledger = StudentLedger::with('feeStructure', 'student.university', 'student.course')->findOrFail($id);
    //     $student = $ledger->student;

    //     // Get institute details from authenticated user
    //     $user = auth()->user();

    //     // Full address split into two lines, fallback to '-'
    //     $fullAddress = $user->address ?? '-';
    //     $parts = explode(',', $fullAddress, 3);
    //     $address = (isset($parts[0]) ? trim($parts[0]) : '-')
    //              . ',' . (isset($parts[1]) ? trim($parts[1]) : '-')
    //              . '<br>' . (isset($parts[2]) ? trim($parts[2]) : '-');

    //     $instituteName = $user->name ?? '-';
    //     $logo = $user->profile_photo_path ?? 'https://via.placeholder.com/150x60?text=Logo';

    //     // Prepare PDF data, use default values if any field is null
    //     $data = [
    //         'student_name'      => $student->full_name ?? '-',
    //         'application_id'    => $student->id ?? '-',
    //         'student_unique_id' => $student->student_unique_id ?? '-',
    //         'phone'             => $student->mobile ?? '-',
    //         'email'             => $student->email ?? '-',
    //         'course'            => $student->course->name ?? 'N/A',
    //         'semester'          => $ledger->feeStructure->semester ?? '-',
    //         'amount'            => $ledger->amount ? number_format($ledger->amount, 2) : '0.00',
    //         'mode'              => $ledger->payment_mode ?? '-',
    //         'transaction_id'    => $ledger->utr_no ?? '-',
    //         'receipt_no'        => $ledger->id ?? '-',
    //         'university_name'   => $student->university->name ?? '-',
    //         'date'              => $ledger->created_at ? $ledger->created_at->format('d M Y') : '-',
    //         'theme'             => $instituteName,
    //         'address'           => $address,
    //         'logo'              => $logo,
    //         'user_gst'          => $user->gst ?? '-',
    //     ];

    //     $pdf = Pdf::loadView('accounts.ledger.receipt', $data);

    //     return $pdf->download('Payment_Receipt_' . ($student->full_name ?? 'student') . '.pdf');
    // }




    //before 01-12-2025 for all download

    public function downloadReceipt($id)
    {

        // Get Active Theme
        $theme = Theme::where('is_active', 1)->first();

        // Get ledger + relations
        $ledger = StudentLedger::with('feeStructure', 'student.university', 'student.course')
            ->findOrFail($id);

        $student = $ledger->student;
        $user = auth()->user();



        // Address formatting
        $fullAddress = $theme->address ?? '-';
        $parts = explode(',', $fullAddress, 3);

        $address = (isset($parts[0]) ? trim($parts[0]) : '-') . ',' .
            (isset($parts[1]) ? trim($parts[1]) : '-') . '<br>' .
            (isset($parts[2]) ? trim($parts[2]) : '-');

        $gstNumber   = $theme->gst ?? '-';


        // Logo from THEME
        $logo = $theme && $theme->logo
            ? public_path($theme->logo)
            : public_path('default-logo.png');

        // Semester Fee Logic
        $semesterFee      = $ledger->feeStructure->amount ?? 0;
        $semesterDiscount = $ledger->feeStructure->discount ?? 0;
        $semesterTotal    = $semesterFee - $semesterDiscount;

        $semesterPaid = StudentLedger::where('student_fee_id', $ledger->student_fee_id)
            ->where('transaction_type', 'credit')
            ->sum('amount');

        $semesterBalance = $semesterTotal - $semesterPaid;


        // PDF data
        $data = [
            'student_name'      => $student->full_name ?? '-',
            'application_id'    => $student->id ?? '-',
            'student_unique_id' => $student->student_unique_id ?? '-',
            'phone'             => $student->mobile ?? '-',
            'email'             => $student->email ?? '-',
            'course'            => $student->course->name ?? 'N/A',
            'university_name'   => $student->university->name ?? '-',
            'semester'          => $ledger->feeStructure->semester ?? '-',

            'amount'            => number_format($ledger->amount, 2),
            'mode'              => $ledger->payment_mode ?? '-',
            'transaction_id'    => $ledger->utr_no ?? '-',
            'receipt_no'        => $ledger->id ?? '-',
            'date'              => $ledger->created_at ? $ledger->created_at->format('d-m-Y') : '-',

            'theme'             => $theme->name ?? '-',
            'address'           => $address,
            'gst'      => $gstNumber,
            'logo'              => $logo,

            'semester_fee'      => number_format($semesterFee, 2),
            'semester_discount' => number_format($semesterDiscount, 2),
            'semester_total'    => number_format($semesterTotal, 2),
            'semester_paid'     => number_format($semesterPaid, 2),
            'semester_balance'  => number_format($semesterBalance, 2),
        ];

        // dd($data);


        // Generate PDF
        $pdf = Pdf::loadView('accounts.ledger.single_receipt', $data)->setPaper('A4', 'portrait');

        return $pdf->download('Payment_Receipt_' . ($student->full_name ?? 'student') . '.pdf');
    }








    public function downloadSemesterReceipts($student_id, $semester)
    {
        $ledgers = StudentLedger::with('feeStructure', 'student', 'student.course', 'student.university')
            ->where('student_id', $student_id)
            ->whereHas('feeStructure', fn($q) => $q->where('semester', $semester))
            ->get();

        if ($ledgers->isEmpty()) {
            return back()->with('error', 'No semester entries found.');
        }

        $theme = Theme::where('is_active', 1)->first();
        $entries = $this->buildReceiptData($ledgers, $theme);

        // Sirf entries pass karein
        $student = $ledgers->first()->student;

        $pdf = Pdf::loadView('accounts.ledger.receipt', [
            'student_name' => $student->full_name,
            'student_unique_id' => $student->student_unique_id,
            'course' => $student->course->name ?? 'N/A',
            'university_name' => $student->university->name ?? '-',
            'entries' => $entries
        ])->setPaper('A4');

        return $pdf->download("Semester_{$semester}_Entries.pdf");
    }

    public function downloadAllReceipts($student_id)
    {
        $ledgers = StudentLedger::with('feeStructure', 'student', 'student.course', 'student.university')
            ->where('student_id', $student_id)
            ->get();

        if ($ledgers->isEmpty()) {
            return back()->with('error', 'No entries available.');
        }

        $theme = Theme::where('is_active', 1)->first();
        $entries = $this->buildReceiptData($ledgers, $theme);

        $student = $ledgers->first()->student;

        $pdf = Pdf::loadView('accounts.ledger.receipt', [
            'student_name' => $student->full_name,
            'student_unique_id' => $student->student_unique_id,
            'course' => $student->course->name ?? 'N/A',
            'university_name' => $student->university->name ?? '-',
            'entries' => $entries
        ])->setPaper('A4');

        return $pdf->download("All_Entries_Student_{$student_id}.pdf");
    }


    private function buildReceiptData($ledgers, $theme)
    {
        $allReceipts = [];
        $logo = $theme->logo ? public_path($theme->logo) : public_path('default-logo.png');

        // Sort ledgers by ID in ascending order
        $ledgers = collect($ledgers)->sortBy('id');

        // Group by semester
        $grouped = $ledgers->groupBy(function ($l) {
            return $l->feeStructure->semester ?? 'Misc';
        });

        $grandTotalFee = 0;
        $grandTotalPaid = 0;
        $grandTotalBalance = 0;

        foreach ($grouped as $semester => $rows) {

            // Actual total fee for this semester
            $fee = (float) ($rows->first()->feeStructure->amount ?? 0);
            $discount = (float) ($rows->first()->feeStructure->discount ?? 0);
            $totalSemesterFee = $fee - $discount;

            // Sum of all payments for this semester
            $paidAmount = (float) $rows->sum('amount');

            // Balance
            $balanceAmount = max(0, $totalSemesterFee - $paidAmount);

            // Add to final totals
            $grandTotalFee += $totalSemesterFee;
            $grandTotalPaid += $paidAmount;
            $grandTotalBalance += $balanceAmount;

            foreach ($rows as $ledger) {

                $student = $ledger->student;

                $parts = explode(',', $theme->address ?? '-', 3);
                $address = trim($parts[0] ?? '-') . ',' .
                    trim($parts[1] ?? '-') . '<br>' .
                    trim($parts[2] ?? '-');

                $allReceipts[] = [
                    'student_name'      => $student->full_name,
                    'application_id'    => $student->id,
                    'student_unique_id' => $student->student_unique_id,
                    'phone'             => $student->mobile,
                    'email'             => $student->email,
                    'course'            => $student->course->name ?? 'N/A',
                    'university_name'   => $student->university->name ?? '-',

                    'semester'          => "$semester",

                    // ⭐ ADD ROW WISE AMOUNT
                    'amount'            => (float) $ledger->amount,

                    'mode'              => $ledger->payment_mode,
                    'transaction_id'    => $ledger->utr_no,
                    'receipt_no'        => $ledger->id,
                    'date'              => $ledger->created_at->format('d-m-Y'),

                    'theme'             => $theme->name,
                    'address'           => $address,
                    'gst'               => $theme->gst,
                    'logo'              => $logo,
                ];
            }
        }

        // Summary totals
        $allReceipts['summary'] = [
            'total_fee'    => $grandTotalFee,
            'total_paid'   => $grandTotalPaid,
            'total_balance' => $grandTotalBalance,
            'total_amount' => $grandTotalPaid
        ];

        return $allReceipts;
    }
















    public function editPayment($id)
    {
        // $payment = StudentLedger::with('student.feeStructures')->findOrFail($id);
        // $student = $payment->student;

        // $feeStructures = StudentFeeStructure::where('student_id', $student->id)->get();

        // return view('accounts.ledger.edit', compact('payment', 'student', 'feeStructures'));

        $payment = StudentLedger::with('student.feeStructures')->findOrFail($id);
        $student = $payment->student;
        $feeStructures = $student->feeStructures; // now loaded
        return view('accounts.ledger.edit', compact('payment', 'student', 'feeStructures'));
    }



    public function updatePayment(Request $request)
    {
        $request->validate([
            'payment_id'       => 'required|exists:student_ledgers,id',
            'student_id'       => 'required|exists:students,id',
            'semester'         => 'required|string',
            'amount'           => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'payment_mode'     => 'required|string',
            'utr_no'           => 'nullable|string',
            'remarks'          => 'nullable|string',
        ]);

        try {
            $payment = StudentLedger::findOrFail($request->payment_id);

            // Update linked fee structure id if needed
            $studentFee = StudentFeeStructure::where('student_id', $request->student_id)
                ->where('semester', $request->semester)
                ->first();

            $payment->update([
                'student_id'       => $request->student_id,
                'student_fee_id'   => $studentFee->id ?? null,
                'amount'           => $request->amount,
                'transaction_date' => $request->transaction_date,
                'payment_mode'     => $request->payment_mode,
                'utr_no'           => $request->utr_no,
                'remarks'          => $request->remarks,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Payment updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
