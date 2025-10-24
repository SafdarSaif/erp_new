<?php

namespace App\Http\Controllers;

use App\Models\StudentLedger;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Student;
use App\Models\Accounts\StudentFeeStructure;
use App\Models\MiscellaneousFee;
use App\Models\StudentInvoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf; // if using barryvdh/laravel-dompdf




class StudentLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    // public function ledger($studentId)
    // {
    //     // 1️⃣ Fetch Student with Relations
    //     $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

    //     // 2️⃣ Fetch Fee Structure & Ledger Data
    //     $feeStructures = StudentFeeStructure::where('student_id', $studentId)
    //         ->orderBy('id')
    //         ->get();

    //     $ledgerEntries = StudentLedger::where('student_id', $studentId)
    //         ->orderBy('id')
    //         ->get();

    //     // 3️⃣ Calculate Summary
    //     $totalFee = $student->total_fee ?? 0;
    //     $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');
    //     $balance = $totalFee - $totalPaid;

    //     // 4️⃣ Course Details
    //     $subCourse = $student->subCourse;
    //     $courseName = $subCourse->name ?? '-';
    //     $mode = $subCourse->courseMode->name ?? 'Semesters';
    //     $duration = $subCourse->duration ?? 0;

    //     // 🔹 Static semester fee calculation (like getStudentFeeInfo)
    //     $feePerSem = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

    //     // Generate static semester-wise array (no ledger dependency)
    //     $semesterWiseFees = [];
    //     for ($i = 1; $i <= $duration; $i++) {
    //         $semesterWiseFees[] = [
    //             'semester' => ($mode === 'Yearly') ? "Year $i" : "Semester $i",
    //             'amount'   => $feePerSem,
    //         ];
    //     }

    //     // 5️⃣ Fetch Invoices (optional)
    //     $invoices = StudentInvoice::whereIn('ledger_id', $ledgerEntries->pluck('id'))->get();

    //     // 6️⃣ Pass to View
    //     return view('accounts.fee.ledger', compact(
    //         'student',
    //         'feeStructures',
    //         'ledgerEntries',
    //         'invoices',
    //         'totalFee',
    //         'totalPaid',
    //         'balance',
    //         'courseName',
    //         'mode',
    //         'duration',
    //         'feePerSem',
    //         'semesterWiseFees'
    //     ));
    // }

    // public function ledger($studentId)
    // {
    //     $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

    //     $feeStructures = StudentFeeStructure::where('student_id', $studentId)
    //         ->orderBy('id')
    //         ->get();

    //     $ledgerEntries = StudentLedger::where('student_id', $studentId)
    //         ->orderBy('id')
    //         ->get();

    //     $totalFee  = $student->total_fee ?? 0;
    //     $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');
    //     $balance   = $totalFee - $totalPaid;

    //     $subCourse = $student->subCourse;
    //     $courseName = $subCourse->name ?? '-';
    //     $mode       = $subCourse->courseMode->name ?? 'Semesters';
    //     $duration   = $subCourse->duration ?? 0;
    //     $feePerSem  = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

    //     $semesterWiseFees = [];
    //     for ($i = 1; $i <= $duration; $i++) {
    //         $semesterWiseFees[] = [
    //             'id'       => $feeStructures[$i - 1]->id ?? null, // store DB id if exists
    //             'semester' => ($mode === 'Yearly') ? "Year $i" : "Semester $i",
    //             'amount'   => $feePerSem,
    //         ];
    //     }

    //     $invoices = StudentInvoice::whereIn('ledger_id', $ledgerEntries->pluck('id'))->get();

    //     return view('accounts.fee.ledger', compact(
    //         'student',
    //         'feeStructures',
    //         'ledgerEntries',
    //         'invoices',
    //         'totalFee',
    //         'totalPaid',
    //         'balance',
    //         'courseName',
    //         'mode',
    //         'duration',
    //         'feePerSem',
    //         'semesterWiseFees'
    //     ));
    // }

    // public function ledger($studentId)
    // {
    //     $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

    //     // 🔹 Fetch existing fee structure (if any)
    //     $feeStructures = StudentFeeStructure::where('student_id', $studentId)
    //         ->orderBy('id')
    //         ->get();

    //     // 🔹 Fetch ledger entries for student
    //     $ledgerEntries = StudentLedger::where('student_id', $studentId)
    //         ->orderBy('id')
    //         ->get();

    //     // 🔹 Student & course details
    //     $subCourse  = $student->subCourse;
    //     $courseName = $subCourse->name ?? '-';
    //     $mode       = $subCourse->courseMode->name ?? 'Semesters';
    //     $duration   = $subCourse->duration ?? 0;
    //     $totalFee   = $student->total_fee ?? 0;

    //     // 🔹 CASE 1: If fee structure is already created → show from DB
    //     if ($feeStructures->count() > 0) {
    //         $semesterWiseFees = $feeStructures->map(function ($fee) use ($ledgerEntries) {
    //             $paid = $ledgerEntries
    //                 ->where('student_fee_id', $fee->id)
    //                 ->where('transaction_type', 'credit')
    //                 ->sum('amount');
    //             $balance = $fee->amount - $paid;

    //             return [
    //                 'id'       => $fee->id,
    //                 'semester' => $fee->semester,
    //                 'amount'   => $fee->amount,
    //                 'paid'     => $paid,
    //                 'balance'  => $balance,
    //             ];
    //         });

    //         $totalFee  = $feeStructures->sum('amount');
    //         $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');
    //         $balance   = $totalFee - $totalPaid;
    //     }

    //     // 🔹 CASE 2: If no fee structure exists → generate static structure
    //     else {
    //         $feePerSem = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

    //         $semesterWiseFees = [];
    //         for ($i = 1; $i <= $duration; $i++) {
    //             $semesterWiseFees[] = [
    //                 'id'       => null,
    //                 'semester' => ($mode === 'Yearly') ? "Year $i" : "Semester $i",
    //                 'amount'   => $feePerSem,
    //                 'paid'     => 0,
    //                 'balance'  => $feePerSem,
    //             ];
    //         }

    //         $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');
    //         $balance   = $totalFee - $totalPaid;
    //     }

    //     // 🔹 Fetch invoices (if linked to ledger)
    //     $invoices = StudentInvoice::whereIn('ledger_id', $ledgerEntries->pluck('id'))->get();

    //     return view('accounts.fee.ledger', compact(
    //         'student',
    //         'feeStructures',
    //         'ledgerEntries',
    //         'invoices',
    //         'totalFee',
    //         'totalPaid',
    //         'balance',
    //         'courseName',
    //         'mode',
    //         'duration',
    //         'semesterWiseFees'
    //     ));
    // }


    public function ledger($studentId)
    {
        $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

        //  Fetch existing fee structure
        $feeStructures = StudentFeeStructure::where('student_id', $studentId)
            ->orderBy('id')
            ->get();

        // Fetch ledger entries and join semester from fee structure
        $ledgerEntries = StudentLedger::leftJoin('student_fee_structures', 'student_ledgers.student_fee_id', '=', 'student_fee_structures.id')
            ->select(
                'student_ledgers.*',
                'student_fee_structures.semester as semester' // ✅ Add semester column
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

        //  CASE 1: If fee structure is already created → show from DB
        if ($feeStructures->count() > 0) {
            $semesterWiseFees = $feeStructures->map(function ($fee) use ($ledgerEntries) {
                $paid = $ledgerEntries
                    ->where('student_fee_id', $fee->id)
                    ->where('transaction_type', 'credit')
                    ->sum('amount');
                $balance = $fee->amount - $paid;

                return [
                    'id'       => $fee->id,
                    'semester' => $fee->semester,
                    'amount'   => $fee->amount,
                    'paid'     => $paid,
                    'balance'  => $balance,
                ];
            });

            $totalFee  = $feeStructures->sum('amount');
            $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');
            $balance   = $totalFee - $totalPaid;
        }

        //  CASE 2: If no fee structure exists → generate static structure
        else {
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

            $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');
            $balance   = $totalFee - $totalPaid;
        }

        //  Fetch invoices (if linked to ledger)
        $invoices = StudentInvoice::whereIn('ledger_id', $ledgerEntries->pluck('id'))->get();

        //MiscellaneousFee
        $miscellaneousFee = MiscellaneousFee::where('student_id',$studentId)->get();
        $totalMiscellaneousFee = MiscellaneousFee::where('student_id',$studentId)->sum('amount');
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

            // Optional: Delete existing fee structure for this student
            StudentFeeStructure::where('student_id', $studentId)->delete();

            // Loop through each semester and store in DB
            foreach ($semesters as $index => $semester) {
                StudentFeeStructure::create([
                    'student_id' => $studentId,
                    'semester'   => $semester,
                    'amount'     => $amounts[$index],
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






    // public function loadPaymentModal($studentId)
    // {
    //     $student = Student::findOrFail($studentId);
    //     return view('accounts.ledger.create', compact('student'));
    // }



    // public function getSemesterBalance($id)
    // {
    //     $student = Student::findOrFail($id);

    //     // Get fee structures for this student
    //     $feeStructures = StudentFeeStructure::where('student_id', $id)->get();

    //     $semesterBalances = [];

    //     foreach ($feeStructures as $fee) {
    //         // Sum of credits for this semester
    //         $paid = StudentLedger::where('student_id', $id)
    //             ->where('transaction_type', 'credit')
    //             ->where('student_fee_id', $fee->id) // link ledger to fee structure
    //             ->sum('amount');

    //         $balance = $fee->amount - $paid;

    //         $semesterBalances[] = [
    //             'semester' => $fee->semester,
    //             'total_fee' => $fee->amount,
    //             'paid' => $paid,
    //             'balance' => $balance,
    //         ];
    //     }

    //     return response()->json([
    //         'student' => $student,
    //         'semester_balances' => $semesterBalances,
    //     ]);
    // }


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

            $balance = $fee->amount - $paid;

            $semesterBalances[] = [
                'semester'   => $fee->semester,
                'fee_id'     => $fee->id,
                'total_fee'  => $fee->amount,
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
        return view('accounts.ledger.create', compact('student'));
    }






    // public function savePayment(Request $request)
    // {
    //     //  dd($request);
    //     try {
    //         $ledger = StudentLedger::create([
    //             'student_id'       => $request->student_id,
    //             'student_fee_id'   => $request->student_fee_id, // <- add this
    //             'transaction_type' => 'credit',
    //             'amount'           => $request->amount,
    //             'transaction_date' => $request->transaction_date,
    //             'payment_mode'     => $request->payment_mode,
    //             'utr_no'           => $request->utr_no,
    //             'remarks'          => $request->remarks,
    //         ]);

    //         StudentInvoice::create([
    //             'ledger_id'  => $ledger->id,
    //             'invoice_no' => 'INV-' . strtoupper(Str::random(6)),
    //         ]);

    //         return response()->json(['status' => 'success', 'message' => 'Payment added successfully.']);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    //     }
    // }


    public function savePayment(Request $request)
    {
        try {
            $studentId    = $request->student_id;
            $studentFeeId = $request->student_fee_id;
            $amount       = $request->amount;

            // ✅ Fetch fee structure for the selected semester
            $fee = StudentFeeStructure::findOrFail($studentFeeId);

            // ✅ Calculate total paid so far for this semester
            $paid = StudentLedger::where('student_id', $studentId)
                ->where('student_fee_id', $studentFeeId)
                ->where('transaction_type', 'credit')
                ->sum('amount');

            $balance = $fee->amount - $paid;

            // ✅ Check if balance is zero
            if ($balance <= 0) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'This semester is already fully paid. Cannot add more payment.'
                ]);
            }

            // ✅ Check if amount exceeds balance
            if ($amount > $balance) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Payment amount exceeds the remaining balance for this semester.'
                ]);
            }

            // 🔹 Save ledger entry
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

            // 🔹 Generate invoice
            StudentInvoice::create([
                'ledger_id'  => $ledger->id,
                'invoice_no' => 'INV-' . strtoupper(Str::random(6)),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Payment added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }







    public function downloadReceipt($id)
    {
        $ledger = StudentLedger::with('feeStructure', 'student')->findOrFail($id);

        $student = Student::find($ledger->student_id);

        $courseName = $student->course->name ?? 'N/A';

        $data = [
            'student_name'     => $student->full_name,
            'application_id'   => $student->id ?? '-',
            'email'            => $student->email ?? '-',
            'course'           => $courseName,
            'semester'         => $ledger->feeStructure->semester ?? '-',
            'amount'           => number_format($ledger->amount, 2),
            'mode'             => $ledger->payment_mode,
            'transaction_id'   => $ledger->utr_no ?? '-',
            'date'             => $ledger->created_at->format('d M Y'),
        ];

        $pdf = Pdf::loadView('accounts.ledger.receipt', $data);

        return $pdf->download('Payment_Receipt_' . $student->full_name . '.pdf');
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
