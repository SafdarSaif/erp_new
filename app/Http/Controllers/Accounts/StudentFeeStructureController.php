<?php

namespace App\Http\Controllers\Accounts;

use App\Models\Accounts\StudentFeeStructure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Student;
use App\Models\StudentLedger;
use App\Models\StudentInvoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;








class StudentFeeStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // List all fee structures




    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $fees = StudentFeeStructure::with('student')
    //             ->orderBy('id', 'desc')
    //             ->get();

    //         // dd($fees);

    //         return DataTables::of($fees)
    //             ->addIndexColumn()
    //             ->addColumn('student_name', function ($fee) {
    //                 return $fee->student->full_name ?? '-';
    //             })
    //             ->editColumn('amount', function ($fee) {
    //                 return number_format($fee->amount, 2);
    //             })
    //             ->editColumn('created_at', function ($fee) {
    //                 return $fee->created_at ? $fee->created_at->format('d M Y') : '-';
    //             })
    //             ->editColumn('updated_at', function ($fee) {
    //                 return $fee->updated_at ? $fee->updated_at->format('d M Y') : '-';
    //             })
    //             ->addColumn('action', function ($fee) {
    //                 return '';
    //             })
    //             ->make(true);
    //     }

    //     return view('accounts.fee.index');
    // }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ledgers = StudentLedger::with(['student', 'feeStructure'])
                ->orderBy('id', 'desc')
                ->get();

            return DataTables::of($ledgers)
                ->addIndexColumn()
                ->addColumn('student_name', fn($l) => $l->student->full_name ?? '-')
                ->addColumn('semester', fn($l) => $l->feeStructure->semester ?? '-')
                ->editColumn('amount', fn($l) => number_format($l->amount, 2))
                ->editColumn('created_at', fn($l) => $l->created_at ? $l->created_at->format('d M Y') : '-')
                ->addColumn('action', function ($l) {
                    $receiptUrl = route('student.downloadReceipt', $l->id);
                    return '
                    <div class="hstack gap-2 fs-15">
                        <button class="btn btn-sm btn-light-success" onclick="window.open(\'' . $receiptUrl . '\', \'_blank\')">
                            <i class="bi bi-download"></i> Receipt
                        </button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('accounts.fee.index');
    }




    public function studentindex(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::orderBy('id', 'desc')->get();

            return DataTables::of($students)
                ->addIndexColumn()
                ->editColumn('created_at', function ($student) {
                    return $student->created_at ? $student->created_at->format('d M Y') : '-';
                })
                ->editColumn('updated_at', function ($student) {
                    return $student->updated_at ? $student->updated_at->format('d M Y') : '-';
                })
                ->addColumn('action', function ($student) {
                    return '';
                })
                ->make(true);
        }

        return view('accounts.fee.studentindex');
    }



    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $students = Student::orderBy('id')->get();
        return view('accounts.fee.create', compact('students'));
    }



    public function add()
    {
        $students = Student::orderBy('id')->get();
        return view('accounts.fee.add', compact('students'));
    }






    public function getStudentFeeInfo($studentId)
    {
        $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

        $subCourse = $student->subCourse;
        $duration = $subCourse->duration ?? 0;
        $durationType = $subCourse->courseMode->name ?? 'Semesters';
        $totalFee = $student->total_fee ?? 0;

        $feePerSem = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

        return response()->json([
            'sub_course_id'   => $student->sub_course_id,
            'sub_course_name' => $subCourse->name ?? '-',
            'duration'        => $duration,
            'duration_type'   => $durationType,
            'total_fee'       => $totalFee,
            'fee_per_sem'     => $feePerSem,
        ]);
    }







    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)


    // {
    //     DB::beginTransaction();
    //     try {
    //         $studentId = $request->student_id;
    //         $semesters = $request->semester;
    //         $amounts = $request->amount;
    //         $statuses = $request->payment_status;
    //         $details = $request->payment_details;

    //         foreach ($semesters as $index => $sem) {
    //             $fee = StudentFeeStructure::create([
    //                 'student_id' => $studentId,
    //                 'semester' => $sem,
    //                 'amount' => $amounts[$index],
    //             ]);

    //             if ($statuses[$index] === 'paid') {
    //                 $ledger = StudentLedger::create([
    //                     'student_id' => $studentId,
    //                     'student_fee_id' => $fee->id,
    //                     'transaction_type' => 'credit',
    //                     'amount' => $amounts[$index],
    //                     'payment_mode' => 'Manual Entry',
    //                     'utr_no' => $details[$index],
    //                 ]);

    //                 StudentInvoice::create([
    //                     'ledger_id' => $ledger->id,
    //                     'invoice_no' => 'INV-' . strtoupper(Str::random(6)),
    //                 ]);
    //             }
    //         }

    //         DB::commit();
    //         return response()->json(['status' => 'success', 'message' => 'Student fee added successfully.']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    //     }
    // }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $studentId = $request->student_id;

            foreach ($request->semester as $index => $sem) {
                $amount = $request->amount[$index];
                $status = $request->payment_status[$index];
                $details = $request->payment_details[$index] ?? null;
                $mode = $request->payment_mode[$index] ?? 'Manual Entry';

                // 1️⃣ Create semester record
                $fee = StudentFeeStructure::create([
                    'student_id' => $studentId,
                    'semester'   => $sem,
                    'amount'     => $amount,
                ]);

                // 2️⃣ Always create a DEBIT entry (fee due)
                StudentLedger::create([
                    'student_id'      => $studentId,
                    'student_fee_id'  => $fee->id,
                    'transaction_type' => 'debit',
                    'amount'          => $amount,
                    'payment_mode'    => 'Fee Due',
                    'remarks'         => 'Fee structure entry created',
                ]);

                // 3️⃣ If paid immediately → create CREDIT entry
                if ($status === 'paid') {
                    $ledger = StudentLedger::create([
                        'student_id'      => $studentId,
                        'student_fee_id'  => $fee->id,
                        'transaction_type' => 'credit',
                        'amount'          => $amount,
                        'payment_mode'    => $mode,
                        'utr_no'          => $details,
                    ]);

                    StudentInvoice::create([
                        'ledger_id'   => $ledger->id,
                        'invoice_no'  => 'INV-' . strtoupper(Str::random(6)),
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Student fee added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    // public function savePayment(Request $request)
    // {
    //     try {
    //         $ledger = StudentLedger::create([
    //             'student_id'      => $request->student_id,
    //             'student_fee_id'  => $request->student_fee_id,
    //             'transaction_type' => 'credit',
    //             'amount'          => $request->amount,
    //             'transaction_date' => $request->transaction_date,
    //             'payment_mode'    => $request->payment_mode,
    //             'utr_no'          => $request->utr_no,
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






    // public function getStudentFeeInfo($studentId)
    // {
    //     $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

    //     $subCourse = $student->subCourse;
    //     $duration = $subCourse->duration ?? 0;
    //     $durationType = $subCourse->courseMode->name ?? 'Semesters';
    //     $totalFee = $student->total_fee ?? 0;

    //     // Calculate per semester/year fee
    //     $feePerSem = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

    //     // Generate fee structure array
    //     $feeStructure = [];
    //     for ($i = 1; $i <= $duration; $i++) {
    //         $feeStructure[] = [
    //             'semester' => $i,
    //             'amount' => $feePerSem,
    //             'status' => 'pending',   // by default pending
    //             'balance' => $feePerSem, // initial balance
    //         ];
    //     }

    //     return response()->json([
    //         'sub_course_id'   => $student->sub_course_id,
    //         'sub_course_name' => $subCourse->name ?? '-',
    //         'duration'        => $duration,
    //         'duration_type'   => $durationType,
    //         'total_fee'       => $totalFee,
    //         'fee_per_sem'     => $feePerSem,
    //         'fee_structure'   => $feeStructure, // 🔹 semester-wise entries

    //         // dd($feeStructure)
    //     ]);
    // }

    // public function ledger($studentId)
    // {
    //     $student = Student::with('subCourse.courseMode')->findOrFail($studentId);

    //     // 1️⃣ Fetch Fee Structure & Ledger Data
    //     $feeStructures = StudentFeeStructure::where('student_id', $studentId)
    //         ->orderBy('id')
    //         ->get();

    //     $ledgerEntries = StudentLedger::where('student_id', $studentId)
    //         ->orderBy('id')
    //         ->get();

    //     // 2️⃣ Calculate Summary
    //     $totalFee = $feeStructures->sum('amount');
    //     $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');
    //     $balance = $totalFee - $totalPaid;

    //     // 3️⃣ Fee per Semester and Course Info
    //     $courseName = $student->subCourse->name ?? '-';
    //     $mode = $student->subCourse->courseMode->name ?? '-';
    //     $duration = $student->subCourse->duration ?? 0;
    //     $feePerSem = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

    //     // 4️⃣ Invoices (optional)
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
    //         'feePerSem'
    //     ));
    // }

    //     public function ledger($studentId)
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
    //     // 🔹 Get total fee directly from students table
    //     $totalFee = $student->total_fee ?? 0;

    //     // 🔹 Calculate total paid amount (credit transactions)
    //     $totalPaid = $ledgerEntries->where('transaction_type', 'credit')->sum('amount');

    //     // 🔹 Calculate balance
    //     $balance = $totalFee - $totalPaid;

    //     // 4️⃣ Course Details
    //     $courseName = $student->subCourse->name ?? '-';
    //     $mode = $student->subCourse->courseMode->name ?? '-';
    //     $duration = $student->subCourse->duration ?? 0;
    //     $feePerSem = ($duration > 0) ? round($totalFee / $duration, 2) : 0;

    //     // 5️⃣ Fetch Invoices (optional)
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
    //         'feePerSem'
    //     ));
    // }






    /**
     * Display the specified resource.
     */
    public function show(StudentFeeStructure $studentFeeStructure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentFeeStructure $studentFeeStructure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentFeeStructure $studentFeeStructure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentFeeStructure $studentFeeStructure)
    {
        //
    }
}
