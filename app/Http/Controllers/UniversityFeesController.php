<?php

namespace App\Http\Controllers;

use App\Models\Academics\Course;
use App\Models\Academics\SubCourse;
use App\Models\Academics\University;
use App\Models\Settings\AcademicYear;
use App\Models\Settings\AdmissionMode;
use App\Models\Settings\BloodGroup;
use App\Models\Settings\Category;
use App\Models\Settings\CourseMode;
use App\Models\Settings\CourseType;
use App\Models\Settings\Language;
use App\Models\Settings\Religion;
use App\Models\Student;
use App\Models\UniversityFees;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UniversityFeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd('here');
        if ($request->ajax()) {
            $students = Student::with(['university', 'course', 'subCourse'])
                ->orderBy('id', 'desc');

            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('university', fn($row) => $row->university->name ?? '-')
                ->addColumn('course', fn($row) => $row->course->name ?? '-')
                ->addColumn('sub_course', fn($row) => $row->subCourse->name ?? '-')
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-sm btn-primary add-fee-btn" data-id="' . $row->id . '">
                                <i class="fa fa-plus"></i> Add Fee
                            </button>';
                })
                ->rawColumns(['action'])
                ->filter(function ($query) use ($request) {
                    if (!empty($request->columns[1]['search']['value'])) {
                        $query->where('full_name', 'like', '%' . $request->columns[1]['search']['value'] . '%');
                    }
                })
                ->make(true);
        }

        return view('accounts.university-fee.index', [
            'academicYears' => AcademicYear::all(),
            'universities' => University::all(),
            'courseTypes' => CourseType::all(),
            'courses' => Course::all(),
            'subCourses' => SubCourse::all(),
            'modes' => AdmissionMode::all(),
            'courseModes' => CourseMode::all(),
            'languages' => Language::all(),
            'bloodGroups' => BloodGroup::all(),
            'religions' => Religion::all(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Fetch fee and transaction details for selected student.
     */
    public function show($id)
    {
        $student = Student::with(['university', 'course', 'subCourse'])->findOrFail($id);

        $universityFeesInfo = UniversityFees::where('student_id', $id)->get();

        // Sum only successful payments
        $pay_university_fees = $universityFeesInfo
            ->where('status', 'success') // filter collection by status
            ->sum('amount');

        // Calculate pending fee
        $university_fee = $student->subCourse->university_fee ?? 0;
        $pending_fee = $university_fee - $pay_university_fees;

        return response()->json([
            'student' => [
                'student_id' => $student->id,
                'full_name' => $student->full_name,
                'university' => $student->university->name ?? '-',
                'course' => $student->course->name ?? '-',
                'sub_course' => $student->subCourse->name ?? '-',
                'fee' => $university_fee,
                'pending_fee' => $pending_fee > 0 ? $pending_fee : 0,
            ],
            'universityFeesInfo' => $universityFeesInfo,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $studentId = $request->get('student_id');
        return view('accounts.university-fee.create', compact('studentId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'studentId' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:20',
            'date' => 'required|date',
            'mode' => 'required|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
        ]);

        $student = Student::with('subCourse', 'university', 'course')->findOrFail($request->studentId);

        $university_fee = $student->subCourse->university_fee ?? 0;

        // Sum only successful payments
        $paid_amount = UniversityFees::where('student_id', $student->id)
            ->where('status', 'success')
            ->sum('amount');

        $pending_fee = $university_fee - $paid_amount;

        if ($request->amount > $pending_fee) {
            return response()->json([
                'success' => false,
                'message' => "Transaction amount cannot exceed the pending university fee of ₹{$pending_fee}.",
            ], 422);
        }

        UniversityFees::create([
            'student_id' => $student->id,
            'university_id' => $student->university_id,
            'course_id' => $student->course_id,
            'amount' => $request->amount,
            'status' => $request->status,
            'date' => $request->date,
            'mode' => $request->mode,
            'transaction_id' => $request->transaction_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'University fee transaction added successfully.',
            'pending_fee' => $pending_fee - $request->amount
        ]);
    }


    public function updateFee(Request $request, $studentId)
    {
        $request->validate([
            'university_fee' => 'required|numeric|min:0',
        ]);

        try {
            // Find student to get sub_course_id
            $student = Student::findOrFail($studentId);

            // Find related sub course
            $subCourse = SubCourse::find($student->sub_course_id);
            if ($subCourse) {
                $subCourse->university_fee = $request->university_fee;
                $subCourse->save();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'SubCourse not found for this student.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'University Fee updated successfully in SubCourse!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update fee: ' . $e->getMessage()
            ], 500);
        }
    }

public function UnversityFeeTransactionHistory(Request $request)
{
    if ($request->ajax()) {
        $data = UniversityFees::with(['student', 'university', 'course'])
            ->latest()
            ->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('student_name', fn($row) => $row->student->full_name ?? '-')
            ->addColumn('university_name', fn($row) => $row->university->name ?? '-')
            ->addColumn('course_name', fn($row) => $row->course->name ?? '-')
            ->addColumn('date', fn($row) => \Carbon\Carbon::parse($row->date)->format('d-M-Y h:i A'))
            ->rawColumns(['status'])
            ->make(true);
    }

    return view('accounts.university-payments.index'); // your blade path
}

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UniversityFees $universityFees)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UniversityFees $universityFees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UniversityFees $universityFees)
    {
        //
    }
}
