<?php

namespace App\Http\Controllers;

use App\Models\Academics\Course;
use App\Models\Academics\Department;
use App\Models\Academics\SubCourse;
use App\Models\Academics\University;
use App\Models\Report;
use App\Models\Settings\AcademicYear;
use App\Models\Settings\AdmissionMode;
use App\Models\Settings\BloodGroup;
use App\Models\Settings\Category;
use App\Models\Settings\CourseMode;
use App\Models\Settings\CourseType;
use App\Models\Settings\Language;
use App\Models\Settings\Religion;
use App\Models\Student;
use App\Models\StudentLedger;
use App\Models\UniversityFees;
use App\Models\Accounts\StudentFeeStructure;
use App\Models\MiscellaneousFee;
use App\Models\Voucher;
use App\Models\Payment;
use App\Models\Settings\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function studentReport()
    {
        try {
            if (request()->ajax()) {
                // Load related department and course type
                $data = Report::all();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($report) {
                        return Carbon::parse($report->created_at)->format('Y-m-d');
                    })
                    ->make(true);
            }
            return view('reports.student');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function createStudentReport()
    {
        $universities = University::all();
        $departments = Department::all();
        $courses = Course::all();
        $subCourses = SubCourse::all();
        $academicYears = AcademicYear::all();
        $admissionModes = AdmissionMode::all();
        $courseModes = CourseMode::all();
        $bloodGroups = BloodGroup::all();
        $categories = Category::all();
        $courseTypes = CourseType::all();
        $languages = Language::all();
        $religions = Religion::all();
        return view('reports.create', compact('universities', 'departments', 'courses', 'subCourses', 'academicYears', 'admissionModes', 'courseModes', 'bloodGroups', 'categories', 'courseTypes', 'languages', 'religions'));
    }

    public function storeStudentReport(Request $request)
    {
        try {
            $storeData['for'] = "students";
            $storeData['name'] = $request->tag;
            $request->request->remove('tag');
            $request->request->remove('_token');
            $storeData['filter'] = json_encode($request->all());
            $store = Report::create($storeData);
            return response()->json([
                'status' => 'success',
                'message' => 'Report Generated go to report and download',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function viewStudentReport(Request $request, $id)
    {
        try {
            $report = Report::findOrFail($id);
            $filter = json_decode($report->filter, true);
            $student = new Student();
            foreach ($filter as $column => $value) {
                $student->where($column, $value);
            }
            $students = $student->get();
            if (request()->ajax()) {
                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('academic_year', fn($row) => $row->academicYear?->name ?? '-')
                    ->addColumn('university', fn($row) => $row->university?->name ?? '-')
                    ->addColumn('course_type', fn($row) => $row->courseType?->name ?? '-')
                    ->addColumn('course', fn($row) => $row->course?->name ?? '-')
                    ->addColumn('sub_course', fn($row) => $row->subCourse?->name ?? '-')
                    ->addColumn('mode', fn($row) => $row->mode?->name ?? '-')
                    ->addColumn('course_mode', fn($row) => $row->courseMode?->name ?? '-')
                    ->addColumn('language', fn($row) => $row->language?->name ?? '-')
                    ->addColumn('blood_group', fn($row) => $row->bloodGroup?->name ?? '-')
                    ->addColumn('religion', fn($row) => $row->religion?->name ?? '-')
                    ->addColumn('category', fn($row) => $row->category?->name ?? '-')
                    ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                    ->filter(function ($query) use ($request) {

                        // 🔍 Filter by Full Name
                        if (!empty($request->columns[1]['search']['value'])) {
                            $query->where('full_name', 'like', '%' . $request->columns[1]['search']['value'] . '%');
                        }

                        // 🔍 Filter by Email
                        if (!empty($request->columns[2]['search']['value'])) {
                            $query->where('email', 'like', '%' . $request->columns[2]['search']['value'] . '%');
                        }

                        // 🔍 Filter by Mobile
                        if (!empty($request->columns[3]['search']['value'])) {
                            $query->where('mobile', 'like', '%' . $request->columns[3]['search']['value'] . '%');
                        }

                        // 🔍 Filter by Academic Year
                        if (!empty($request->columns[4]['search']['value'])) {
                            $query->whereHas('academicYear', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[4]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by University
                        if (!empty($request->columns[5]['search']['value'])) {
                            $query->whereHas('university', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[5]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Course Type
                        if (!empty($request->columns[6]['search']['value'])) {
                            $query->whereHas('courseType', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[6]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Course
                        if (!empty($request->columns[7]['search']['value'])) {
                            $query->whereHas('course', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[7]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Sub Course
                        if (!empty($request->columns[8]['search']['value'])) {
                            $query->whereHas('subCourse', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[8]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Mode
                        if (!empty($request->columns[9]['search']['value'])) {
                            $query->whereHas('mode', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[9]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Course Mode
                        if (!empty($request->columns[10]['search']['value'])) {
                            $query->whereHas('courseMode', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[10]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Language
                        if (!empty($request->columns[11]['search']['value'])) {
                            $query->whereHas('language', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[11]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Blood Group
                        if (!empty($request->columns[12]['search']['value'])) {
                            $query->whereHas('bloodGroup', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[12]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Religion
                        if (!empty($request->columns[13]['search']['value'])) {
                            $query->whereHas('religion', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[13]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Category
                        if (!empty($request->columns[14]['search']['value'])) {
                            $query->whereHas('category', function ($q) use ($request) {
                                $q->where('name', 'like', '%' . $request->columns[14]['search']['value'] . '%');
                            });
                        }

                        // 🔍 Filter by Status
                        if (isset($request->columns[15]['search']['value']) && $request->columns[15]['search']['value'] !== '') {
                            $query->where('status', $request->columns[15]['search']['value']);
                        }
                    })
                    ->make(true);
            }
            return view('reports.student_list', [
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
                'id' => $id
            ]);
        } catch (\Exception $e) {
            response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function incomeReport()
    {
        $universities = University::all();
        return view('reports.income', compact('universities'));
    }

    public function getIncome(Request $request)
    {
        $dates = json_decode($request->daterange, true);  // convert to array
        $mode = $request->mode;
        $university = $request->university;
        $fee_type = $request->fee_type;

        // Only when university is selected, get student IDs once
        $universityStudent = Student::where('university_id', $university)->pluck('id')->toArray();

        $payments = StudentLedger::with('student');  // query builder

        if (!empty($mode)) {
            $payments = $payments->where('payment_mode', $mode);
        }

        if (!empty($university)) {
            $payments = $payments->whereIn('student_id', $universityStudent);
        }

        if (!empty($dates) && isset($dates[0]) && isset($dates[1])) {
            $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
            $end   = date('Y-m-d 23:59:59', strtotime($dates[1]));
            $payments = $payments->whereBetween('created_at', [$start, $end]);
        }

        if (!empty($fee_type)) {
            if ($fee_type == "student_fee") {
                $payments = $payments->whereNull('miscellaneous_id');
            } else {
                $payments = $payments->whereNotNull('miscellaneous_id');
            }
        }
        $data = $payments->get();
        return response()->json($data);
    }





    // public function expenceReport()
    // {


    //     $universities = University::all();
    //     $students = Student::all();
    //     $courses = Course::all();
    //     return view('reports.expence', compact('universities', 'students', 'courses'));
    // }




    // public function getExpense(Request $request)
    // {
    //     try {
    //         $dates = json_decode($request->daterange, true);
    //         $university = $request->university;
    //         $mode = $request->mode;
    //         $student = $request->student;
    //         $course = $request->course;

    //         $expenses = \App\Models\UniversityFees::with(['university', 'student', 'course'])->where('status', 'success');

    //         if (!empty($university)) {
    //             $expenses->where('university_id', $university);
    //         }

    //         if (!empty($mode)) {
    //             $expenses->where('mode', $mode);
    //         }

    //         if (!empty($student)) {
    //             $expenses->where('student_id', $student);
    //         }

    //         if (!empty($course)) {
    //             $expenses->where('course_id', $course);
    //         }

    //         if (!empty($dates) && isset($dates[0]) && isset($dates[1])) {
    //             $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
    //             $end   = date('Y-m-d 23:59:59', strtotime($dates[1]));
    //             $expenses->whereBetween('created_at', [$start, $end]);
    //         }

    //         $data = $expenses->get();
    //         $totalExpense = $data->sum('amount');

    //         return response()->json([
    //             'data' => $data,
    //             'total' => number_format($totalExpense, 2)
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }

    //perfected version below
    // public function getExpense(Request $request)
    // {
    //     try {
    //         $dates = json_decode($request->daterange, true);
    //         $university = $request->university;
    //         $mode = $request->mode;
    //         $student = $request->student;
    //         $course = $request->course;

    //         // ---------------------------------------
    //         // 🟢 FETCH UNIVERSITY FEES EXPENSES
    //         // ---------------------------------------
    //         $feesQuery = \App\Models\UniversityFees::with(['university', 'student', 'course'])
    //             ->where('status', 'success');

    //         if (!empty($university)) {
    //             $feesQuery->where('university_id', $university);
    //         }

    //         if (!empty($mode)) {
    //             $feesQuery->where('mode', $mode);
    //         }

    //         if (!empty($student)) {
    //             $feesQuery->where('student_id', $student);
    //         }

    //         if (!empty($course)) {
    //             $feesQuery->where('course_id', $course);
    //         }

    //         if (!empty($dates) && isset($dates[0]) && isset($dates[1])) {
    //             $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
    //             $end   = date('Y-m-d 23:59:59', strtotime($dates[1]));
    //             $feesQuery->whereBetween('created_at', [$start, $end]);
    //         }

    //         $fees = $feesQuery->get()->map(function ($item) {
    //             return [
    //                 'source' => 'University Fees',
    //                 'student' => $item->student->full_name ?? '-',
    //                 'course' => $item->course->name ?? '-',
    //                 'university' => $item->university->name ?? '-',
    //                 'date' => $item->created_at,
    //                 'mode' => $item->mode ?? '-',
    //                 'amount' => $item->amount ?? 0,
    //             ];
    //         });

    //         // ---------------------------------------
    //         // 🟡 FETCH VOUCHER PAYMENTS
    //         // ---------------------------------------
    //         $voucherQuery = \App\Models\Voucher::with(['expenseCategory', 'payments'])
    //             ->whereHas('payments', function ($q) {
    //                 $q->where('status', '1'); // adjust according to your status column
    //             });

    //         if (!empty($mode)) {
    //             $voucherQuery->where('payment_mode', $mode);
    //         }

    //         if (!empty($dates) && isset($dates[0]) && isset($dates[1])) {
    //             $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
    //             $end   = date('Y-m-d 23:59:59', strtotime($dates[1]));
    //             $voucherQuery->whereBetween('date', [$start, $end]);
    //         }

    //         $vouchers = $voucherQuery->get()->map(function ($item) {
    //             return [
    //                 'source' => 'Voucher Payment',
    //                 'student' => '-',
    //                 'course' => '-',
    //                 'university' => $item->expenseCategory->name ?? '-',
    //                 'date' => $item->date,
    //                 'mode' => $item->payment_mode ?? '-',
    //                 'amount' => $item->amount ?? 0,
    //             ];
    //         });

    //         // ---------------------------------------
    //         // 🔵 MERGE BOTH COLLECTIONS
    //         // ---------------------------------------
    //         $data = $fees->merge($vouchers)->sortByDesc('date')->values();

    //         $totalExpense = $data->sum('amount');

    //         return response()->json([
    //             'data' => $data,
    //             'total' => number_format($totalExpense, 2),
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage(),
    //         ]);
    //     }
    // }



    public function expenceReport()
    {
        $universities = University::all();
        $students = Student::all();
        $courses = Course::all();
        $voucherCategories = ExpenseCategory::all();
        $users = \App\Models\User::all();

        return view('reports.expence', compact('universities', 'students', 'courses', 'voucherCategories', 'users'));
    }


    // public function getExpense(Request $request)
    // {
    //     try {
    //         $dates = json_decode($request->daterange, true);
    //         $university = $request->university;
    //         $mode = $request->mode;
    //         $student = $request->student;
    //         $course = $request->course;
    //         $source = $request->source;
    //         $voucherCategory = $request->voucher_category;
    //         $voucherType = $request->voucher_type;
    //         $addedBy = $request->added_by;

    //         $start = !empty($dates[0]) ? date('Y-m-d 00:00:00', strtotime($dates[0])) : null;
    //         $end   = !empty($dates[1]) ? date('Y-m-d 23:59:59', strtotime($dates[1])) : null;

    //         $data = collect();

    //         // -----------------------------------
    //         // 🟢 UNIVERSITY FEES
    //         // -----------------------------------
    //         if (empty($source) || $source === 'university_fees') {
    //             $feesQuery = \App\Models\UniversityFees::with(['university', 'student', 'course'])
    //                 ->where('status', 'success');

    //             if ($university) $feesQuery->where('university_id', $university);
    //             if ($mode) $feesQuery->where('mode', $mode);
    //             if ($student) $feesQuery->where('student_id', $student);
    //             if ($course) $feesQuery->where('course_id', $course);
    //             if ($addedBy) $feesQuery->where('created_by', $addedBy);
    //             if ($start && $end) $feesQuery->whereBetween('created_at', [$start, $end]);

    //             $fees = $feesQuery->get()->map(function ($f) {
    //                 return [
    //                     'source' => 'University Fees',
    //                     'student' => $f->student->full_name ?? '-',
    //                     'course' => $f->course->name ?? '-',
    //                     'university' => $f->university->name ?? '-',
    //                     'date' => $f->created_at,
    //                     'mode' => $f->mode ?? '-',
    //                     'amount' => $f->amount ?? 0,
    //                 ];
    //             });

    //             $data = $data->merge($fees);
    //         }

    //         // -----------------------------------
    //         // 🟡 VOUCHER PAYMENTS
    //         // -----------------------------------
    //         if (empty($source) || $source === 'voucher_payment') {
    //             $voucherQuery = \App\Models\Payment::with(['expenseCategory'])
    //                 ->where('status', 1);

    //             if ($voucherCategory) $voucherQuery->where('expense_category_id', $voucherCategory);
    //             if ($voucherType) $voucherQuery->where('voucher_type', $voucherType);
    //             if ($mode) $voucherQuery->where('payment_mode', $mode);
    //             if ($addedBy) $voucherQuery->where('created_by', $addedBy);
    //             if ($start && $end) $voucherQuery->whereBetween('created_at', [$start, $end]);

    //             $vouchers = $voucherQuery->get()->map(function ($v) {
    //                 return [
    //                     'source' => 'Voucher Payment',
    //                     'student' => '-',
    //                     'course' => '-',
    //                     'university' => $v->expenseCategory->name ?? '-',
    //                     'date' => $v->date,
    //                     'mode' => $v->payment_mode ?? '-',
    //                     'amount' => $v->amount ?? 0,
    //                 ];
    //             });

    //             $data = $data->merge($vouchers);
    //         }

    //         // -----------------------------------
    //         // 🔵 FINAL MERGE
    //         // -----------------------------------
    //         $data = $data->sortByDesc('date')->values();
    //         $totalExpense = $data->sum('amount');

    //         return response()->json([
    //             'data' => $data,
    //             'total' => number_format($totalExpense, 2),
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage(),
    //         ]);
    //     }
    // }

    public function getExpense(Request $request)
    {
        try {
            $dates = json_decode($request->daterange, true);
            $university = $request->university;
            $mode = $request->mode;
            $student = $request->student;
            $course = $request->course;
            $source = $request->source;
            $voucherCategory = $request->voucher_category;
            $voucherType = $request->voucher_type;
            $addedBy = $request->added_by;

            // 🔹 Date Range
            $start = !empty($dates[0]) ? date('Y-m-d 00:00:00', strtotime($dates[0])) : null;
            $end   = !empty($dates[1]) ? date('Y-m-d 23:59:59', strtotime($dates[1])) : null;

            $data = collect();

            /* =======================================================
           🟢 UNIVERSITY FEES
        ======================================================= */
            if (empty($source) || $source === 'university_fees') {
                $feesQuery = \App\Models\UniversityFees::with(['university', 'student', 'course'])
                    ->where('status', 'success');

                if ($university) $feesQuery->where('university_id', $university);
                if ($mode) $feesQuery->where('mode', $mode);
                if ($student) $feesQuery->where('student_id', $student);
                if ($course) $feesQuery->where('course_id', $course);
                if ($addedBy) $feesQuery->where('added_by', $addedBy);
                if ($start && $end) $feesQuery->whereBetween('created_at', [$start, $end]);

                $fees = $feesQuery->get()->map(function ($f) {
                    return [
                        'source' => 'University Fees',
                        'voucher_type' => '-',
                        'expense_category' => '-',
                        'student' => $f->student->full_name ?? '-',
                        'course' => $f->course->name ?? '-',
                        'university' => $f->university->name ?? '-',
                        'date' => $f->created_at,
                        'mode' => $f->mode ?? '-',
                        'amount' => (float) ($f->amount ?? 0),
                    ];
                });

                $data = $data->merge($fees);
            }

            /* =======================================================
           🟡 VOUCHER PAYMENTS
        ======================================================= */
            if (empty($source) || $source === 'voucher_payment') {
                $voucherQuery = \App\Models\Voucher::with(['expenseCategory', 'payments'])
                    ->whereHas('payments', function ($q) {
                        $q->where('status', 1);
                    });

                if ($voucherCategory) $voucherQuery->where('expense_category_id', $voucherCategory);
                if ($voucherType) $voucherQuery->where('voucher_type', $voucherType);
                if ($mode) $voucherQuery->where('payment_mode', $mode);
                if ($addedBy) $voucherQuery->where('added_by', $addedBy);
                if ($start && $end) $voucherQuery->whereBetween('date', [$start, $end]);

                $vouchers = $voucherQuery->get()->map(function ($v) {
                    return [
                        'source' => 'Voucher Payment',
                        'voucher_type' => $v->voucher_type ?? '-',
                        'university' => $v->expenseCategory->name ?? '-', // ✅ working category name
                        'student' => '-',
                        'course' => '-',
                        // 'university' => '-',
                        'date' => $v->date ?? $v->created_at,
                        'mode' => $v->payment_mode ?? '-',
                        'amount' => (float) ($v->amount ?? 0),
                    ];
                });

                $data = $data->merge($vouchers);
                // dd($data);
            }

            /* =======================================================
           🔵 FINAL MERGE & RESPONSE
        ======================================================= */
            $data = $data->sortByDesc('date')->values();
            $totalExpense = $data->sum('amount');

            return response()->json([
                'data' => $data,
                'total' => number_format($totalExpense, 2),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }







    public function PendingReport()
    {
        $universities = University::all();
        $courses      = Course::all();
        $students     = Student::all();

        return view('reports.pending', compact('universities', 'courses', 'students'));
    }



    public function pendingFeesReport(Request $request)
    {
        $query = Student::query()->with('university', 'course', 'subCourse', 'subCourse.courseMode');

        // Apply filters
        if ($request->filled('university')) {
            $query->where('university_id', $request->university);
        }

        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        if ($request->filled('student')) {
            $query->where('id', $request->student);
        }

        $students = $query->get();

        $data = [];

        foreach ($students as $student) {
            $feeStructures = StudentFeeStructure::where('student_id', $student->id)->get();
            $miscFees      = MiscellaneousFee::where('student_id', $student->id)->get();
            $ledgerEntries = StudentLedger::where('student_id', $student->id)
                ->where('transaction_type', 'credit')
                ->get();

            $totalFee = $feeStructures->sum('amount');
            $totalMisc = $miscFees->sum('amount');

            $paidFee = $ledgerEntries->whereNotNull('student_fee_id')->sum('amount');
            $paidMisc = $ledgerEntries->whereNotNull('miscellaneous_id')->sum('amount');

            $semesterBalances = $feeStructures->map(function ($fee) use ($ledgerEntries) {
                $paid = $ledgerEntries->where('student_fee_id', $fee->id)->sum('amount');
                return [
                    'semester' => $fee->semester,
                    'total'    => $fee->amount,
                    'paid'     => $paid,
                    'balance'  => $fee->amount - $paid
                ];
            });

            $miscBalances = $miscFees->map(function ($misc) use ($ledgerEntries) {
                $paid = $ledgerEntries->where('miscellaneous_id', $misc->id)->sum('amount');
                return [
                    'head'    => $misc->head,
                    'total'   => $misc->amount,
                    'paid'    => $paid,
                    'balance' => $misc->amount - $paid
                ];
            });

            $data[] = [
                'student' => $student,
                'university_name' => $student->university->name ?? 'N/A',
                'course_name'       => $student->course->name ?? 'N/A',
                'subcourse_name'    => $student->subCourse->name ?? 'N/A',
                'semesterBalances' => $semesterBalances,
                'miscBalances'     => $miscBalances,
                'total_due'        => ($totalFee + $totalMisc) - ($paidFee + $paidMisc)
            ];

            // dd($data);
        }

        return response()->json(['data' => $data]);
    }




    // public function profitReport()
    // {
    //     $universities = University::all();
    //     return view('reports.profit', compact('universities'));
    // }

    // public function getProfitReport(Request $request)
    // {
    //     try {
    //         $dates = json_decode($request->daterange, true);
    //         $university = $request->university;

    //         // 🎓 If a specific university is selected, filter students for that
    //         $universityIds = !empty($university)
    //             ? [$university]
    //             : University::pluck('id')->toArray();

    //         $reportData = [];

    //         foreach ($universityIds as $uid) {
    //             // 🧾 Student count
    //             $studentCount = Student::where('university_id', $uid)->count();

    //             // 💰 Total Income
    //             $incomeQuery = StudentLedger::whereHas('student', fn($q) => $q->where('university_id', $uid));
    //             // Date filter
    //             if (!empty($dates) && isset($dates[0]) && isset($dates[1])) {
    //                 $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
    //                 $end   = date('Y-m-d 23:59:59', strtotime($dates[1]));
    //                 $incomeQuery->whereBetween('created_at', [$start, $end]);
    //             }
    //             $income = $incomeQuery->sum('amount');

    //             // 💸 Total Expense
    //             $expenseQuery = UniversityFees::where('university_id', $uid)->where('status', 'success');
    //             if (!empty($dates) && isset($dates[0]) && isset($dates[1])) {
    //                 $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
    //                 $end   = date('Y-m-d 23:59:59', strtotime($dates[1]));
    //                 $expenseQuery->whereBetween('created_at', [$start, $end]);
    //             }
    //             $expense = $expenseQuery->sum('amount');

    //             // 📊 Profit Calculation
    //             $profit = $income - $expense;

    //             $reportData[] = [
    //                 'university' => University::find($uid)?->name ?? 'Unknown',
    //                 'student_count' => $studentCount,
    //                 'income' => number_format($income, 2),
    //                 'expense' => number_format($expense, 2),
    //                 'profit' => number_format($profit, 2)
    //             ];
    //         }

    //         return response()->json(['data' => $reportData]);
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }



    public function profitReport()
    {
        $users = \App\Models\User::all(); // ✅ replaced University with User
        return view('reports.profit', compact('users'));
    }

    public function getProfitReport(Request $request)
    {
        try {
            $dates = json_decode($request->daterange, true);
            $user = $request->user;

            // 🧭 Date Range
            $start = !empty($dates[0]) ? date('Y-m-d 00:00:00', strtotime($dates[0])) : null;
            $end   = !empty($dates[1]) ? date('Y-m-d 23:59:59', strtotime($dates[1])) : null;

            // 🎯 Get list of user IDs to include
            $userIds = !empty($user)
                ? [$user]
                : \App\Models\User::pluck('id')->toArray();

            $reportData = [];

            foreach ($userIds as $uid) {
                //  Student count for this user
                $studentCount = \App\Models\Student::where('added_by', $uid)->count();

                /* =======================================
                TOTAL INCOME
            ======================================= */
                $incomeQuery = \App\Models\StudentLedger::where('added_by', $uid);
                if ($start && $end) $incomeQuery->whereBetween('created_at', [$start, $end]);
                $income = $incomeQuery->sum('amount');

                /* =======================================
                TOTAL EXPENSE (University Fees + Voucher Payment)
            ======================================= */
                // University Fees
                $universityExpense = UniversityFees::where('added_by', $uid)
                    ->where('status', 'success');
                if ($start && $end) $universityExpense->whereBetween('created_at', [$start, $end]);
                $universityExpenseTotal = $universityExpense->sum('amount');

                // Voucher Payments
                $voucherExpense = Voucher::where('added_by', $uid)
                    ->whereHas('payments', function ($q) {
                        $q->where('status', 1);
                    });
                if ($start && $end) $voucherExpense->whereBetween('date', [$start, $end]);
                $voucherExpenseTotal = $voucherExpense->sum('amount');

                // Total Expense
                $totalExpense = $universityExpenseTotal + $voucherExpenseTotal;

                /* =======================================
               📊 PROFIT
            ======================================= */
                $profit = $income - $totalExpense;

                $reportData[] = [
                    'user' => User::find($uid)?->name ?? 'Unknown',
                    'student_count' => $studentCount,
                    'income' => number_format($income, 2),
                    'expense' => number_format($totalExpense, 2),
                    'profit' => number_format($profit, 2),
                ];
            }

            return response()->json(['data' => $reportData]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
