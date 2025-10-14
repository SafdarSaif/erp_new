<?php

namespace App\Http\Controllers;

use App\Models\StudentLedger;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Student;
use App\Models\Accounts\StudentFeeStructure;
use App\Models\StudentInvoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;



class StudentLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function ledger($studentId)
    {
        // 1️⃣ Fetch Student with Relations
        $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

        // 2️⃣ Fetch Fee Structure & Ledger Data
        $feeStructures = StudentFeeStructure::where('student_id', $studentId)
            ->orderBy('id')
            ->get();

        $ledgerEntries = StudentLedger::where('student_id', $studentId)
            ->orderBy('id')
            ->get();

        // 3️⃣ Calculate Summary
        $totalFee = $student->total_fee ?? 0;
        $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');
        $balance = $totalFee - $totalPaid;

        // 4️⃣ Course Details
        $subCourse = $student->subCourse;
        $courseName = $subCourse->name ?? '-';
        $mode = $subCourse->courseMode->name ?? 'Semesters';
        $duration = $subCourse->duration ?? 0;

        // 🔹 Static semester fee calculation (like getStudentFeeInfo)
        $feePerSem = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

        // Generate static semester-wise array (no ledger dependency)
        $semesterWiseFees = [];
        for ($i = 1; $i <= $duration; $i++) {
            $semesterWiseFees[] = [
                'semester' => ($mode === 'Yearly') ? "Year $i" : "Semester $i",
                'amount'   => $feePerSem,
            ];
        }

        // 5️⃣ Fetch Invoices (optional)
        $invoices = StudentInvoice::whereIn('ledger_id', $ledgerEntries->pluck('id'))->get();

        // 6️⃣ Pass to View
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
            'feePerSem',
            'semesterWiseFees'
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
                    'status'     => 1, // active by default
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Semester-wise fee structure saved successfully.'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }








    public function loadPaymentModal($studentId)
    {
        $student = Student::findOrFail($studentId);
        return view('accounts.ledger.create', compact('student'));
    }





    public function savePayment(Request $request)
    {
        try {
            $ledger = StudentLedger::create([
                'student_id'       => $request->student_id,
                'student_fee_id'   => $request->student_fee_id, // <- add this
                'transaction_type' => 'credit',
                'amount'           => $request->amount,
                'transaction_date' => $request->transaction_date,
                'payment_mode'     => $request->payment_mode,
                'utr_no'           => $request->utr_no,
                'remarks'          => $request->remarks,
            ]);

            StudentInvoice::create([
                'ledger_id'  => $ledger->id,
                'invoice_no' => 'INV-' . strtoupper(Str::random(6)),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Payment added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentLedger $studentLedger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentLedger $studentLedger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentLedger $studentLedger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentLedger $studentLedger)
    {
        //
    }
}
