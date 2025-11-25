<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Settings\Religion;
use App\Models\Settings\Category;
use App\Models\Settings\Language;
use App\Models\Settings\BloodGroup;
use App\Models\Settings\AcademicYear;
use App\Models\Academics\University;
use App\Models\Settings\CourseType;
use App\Models\Academics\Course;
use App\Models\Academics\SubCourse;
use App\Models\Settings\AdmissionMode;
use App\Models\Settings\CourseMode;
use App\Models\Settings\Documents;
use App\Models\Settings\Status;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StudentQualification;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Validator;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;




class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {

    //         $students = Student::with([
    //             'academicYear',
    //             'university',
    //             'courseType',
    //             'course',
    //             'subCourse',
    //             'mode',
    //             'courseMode',
    //             'language',
    //             'bloodGroup',
    //             'religion',
    //             'category',
    //             'status'
    //         ])->orderBy('id', 'desc');

    //         // dd($students);

    //         return DataTables::of($students)
    //             ->addIndexColumn()
    //             ->addColumn('student_unique_id', fn($row) => $row->student_unique_id ?? '-') // ✅ Add this line
    //             ->addColumn('academic_year', fn($row) => $row->academicYear?->name ?? '-')
    //             ->addColumn('university', fn($row) => $row->university?->name ?? '-')
    //             ->addColumn('course_type', fn($row) => $row->courseType?->name ?? '-')
    //             ->addColumn('course', fn($row) => $row->course?->name ?? '-')
    //             ->addColumn('sub_course', fn($row) => $row->subCourse?->name ?? '-')
    //             ->addColumn('mode', fn($row) => $row->mode?->name ?? '-')
    //             ->addColumn('course_mode', fn($row) => $row->courseMode?->name ?? '-')
    //             ->addColumn('language', fn($row) => $row->language?->name ?? '-')
    //             ->addColumn('blood_group', fn($row) => $row->bloodGroup?->name ?? '-')
    //             ->addColumn('religion', fn($row) => $row->religion?->name ?? '-')
    //             ->addColumn('category', fn($row) => $row->category?->name ?? '-')
    //             ->addColumn('status', fn($row) => $row->status?->name ?? '-') // ✅ status_id column now used
    //             ->filter(function ($query) use ($request) {

    //                 // 🔍 Filter by Full Name
    //                 if (!empty($request->columns[1]['search']['value'])) {
    //                     $query->where('full_name', 'like', '%' . $request->columns[1]['search']['value'] . '%');
    //                 }

    //                 // 🔍 Filter by Email
    //                 if (!empty($request->columns[2]['search']['value'])) {
    //                     $query->where('email', 'like', '%' . $request->columns[2]['search']['value'] . '%');
    //                 }

    //                 // 🔍 Filter by Mobile
    //                 if (!empty($request->columns[3]['search']['value'])) {
    //                     $query->where('mobile', 'like', '%' . $request->columns[3]['search']['value'] . '%');
    //                 }

    //                 // 🔍 Filter by Academic Year
    //                 if (!empty($request->columns[4]['search']['value'])) {
    //                     $query->whereHas('academicYear', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[4]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by University
    //                 if (!empty($request->columns[5]['search']['value'])) {
    //                     $query->whereHas('university', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[5]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Course Type
    //                 if (!empty($request->columns[6]['search']['value'])) {
    //                     $query->whereHas('courseType', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[6]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Course
    //                 if (!empty($request->columns[7]['search']['value'])) {
    //                     $query->whereHas('course', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[7]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Sub Course
    //                 if (!empty($request->columns[8]['search']['value'])) {
    //                     $query->whereHas('subCourse', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[8]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Mode
    //                 if (!empty($request->columns[9]['search']['value'])) {
    //                     $query->whereHas('mode', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[9]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Course Mode
    //                 if (!empty($request->columns[10]['search']['value'])) {
    //                     $query->whereHas('courseMode', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[10]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Language
    //                 if (!empty($request->columns[11]['search']['value'])) {
    //                     $query->whereHas('language', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[11]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Blood Group
    //                 if (!empty($request->columns[12]['search']['value'])) {
    //                     $query->whereHas('bloodGroup', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[12]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Religion
    //                 if (!empty($request->columns[13]['search']['value'])) {
    //                     $query->whereHas('religion', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[13]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // 🔍 Filter by Category
    //                 if (!empty($request->columns[14]['search']['value'])) {
    //                     $query->whereHas('category', function ($q) use ($request) {
    //                         $q->where('name', 'like', '%' . $request->columns[14]['search']['value'] . '%');
    //                     });
    //                 }

    //                 // // 🔍 Filter by Status
    //                 // if (isset($request->columns[15]['search']['value']) && $request->columns[15]['search']['value'] !== '') {
    //                 //     $query->where('status', $request->columns[15]['search']['value']);
    //                 // }
    //                 // 🔍 Filter by Status (status_id)
    //                 if (!empty($request->columns[15]['search']['value'])) {
    //                     $query->where('status_id', $request->columns[15]['search']['value']);
    //                 }

    //                 // 🔍 Filter by Unique ID
    //                 if (!empty($request->columns[4]['search']['value'])) { // adjust column index if needed
    //                     $query->where('student_unique_id', 'like', '%' . $request->columns[4]['search']['value'] . '%');
    //                 }
    //             })
    //             ->make(true);
    //     }

    //     return view('students.index', [
    //         'academicYears' => AcademicYear::all(),
    //         'universities' => University::all(),
    //         'courseTypes' => CourseType::all(),
    //         'courses' => Course::all(),
    //         'subCourses' => SubCourse::all(),
    //         'modes' => AdmissionMode::all(),
    //         'courseModes' => CourseMode::all(),
    //         'languages' => Language::all(),
    //         'bloodGroups' => BloodGroup::all(),
    //         'religions' => Religion::all(),
    //         'categories' => Category::all(),
    //         'statuses' => Status::all(),
    //     ]);
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::with([
                'academicYear',
                'university',
                'courseType',
                'course',
                'subCourse',
                'mode',
                'courseMode',
                'language',
                'bloodGroup',
                'religion',
                'category',
                'status'
            ])->orderBy('id', 'desc');

            return DataTables::of($students)
                ->addIndexColumn()
                // ->addColumn('student_unique_id', fn($row) => $row->student_unique_id ?? '-')
                ->addColumn('student_unique_id', function ($row) {
                    if ($row->student_unique_id) {
                        return $row->student_unique_id;
                    }
                    // Show Generate button if UniqueID is missing
                    return '<button class="btn btn-sm btn-warning generateID" data-id="' . $row->id . '">Generate</button>';
                })
                ->rawColumns(['student_unique_id']) // allow HTML for button

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
                ->addColumn('status', fn($row) => $row->status?->name ?? '-')
                ->filter(function ($query) use ($request) {

                    $columns = $request->columns;

                    if (!empty($columns[1]['search']['value'])) {
                        $query->where('full_name', 'like', '%' . $columns[1]['search']['value'] . '%');
                    }

                    if (!empty($columns[2]['search']['value'])) {
                        $query->where('email', 'like', '%' . $columns[2]['search']['value'] . '%');
                    }

                    if (!empty($columns[3]['search']['value'])) {
                        $query->where('mobile', 'like', '%' . $columns[3]['search']['value'] . '%');
                    }

                    if (!empty($columns[4]['search']['value'])) {
                        $query->where('student_unique_id', 'like', '%' . $columns[4]['search']['value'] . '%');
                    }

                    if (!empty($columns[5]['search']['value'])) {
                        $query->whereHas(
                            'academicYear',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[5]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[6]['search']['value'])) {
                        $query->whereHas(
                            'university',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[6]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[7]['search']['value'])) {
                        $query->whereHas(
                            'courseType',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[7]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[8]['search']['value'])) {
                        $query->whereHas(
                            'course',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[8]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[9]['search']['value'])) {
                        $query->whereHas(
                            'subCourse',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[9]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[10]['search']['value'])) {
                        $query->whereHas(
                            'mode',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[10]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[11]['search']['value'])) {
                        $query->whereHas(
                            'courseMode',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[11]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[12]['search']['value'])) {
                        $query->whereHas(
                            'language',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[12]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[13]['search']['value'])) {
                        $query->whereHas(
                            'bloodGroup',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[13]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[14]['search']['value'])) {
                        $query->whereHas(
                            'religion',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[14]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[15]['search']['value'])) {
                        $query->whereHas(
                            'category',
                            fn($q) =>
                            $q->where('name', 'like', '%' . $columns[15]['search']['value'] . '%')
                        );
                    }

                    if (!empty($columns[16]['search']['value'])) {
                        $query->where('status_id', $columns[16]['search']['value']);
                    }
                })
                ->make(true);
        }

        return view('students.index', [
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
            'statuses' => Status::all(),
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create', [
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



    public function getDocuments($university_id)
    {
        try {
            $documents = Documents::whereJsonContains('university_id', (string)$university_id)->get();

            // dd($documents);

            return response()->json([
                'status' => 'success',
                'data'   => $documents
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getCourses($universityId)
    {
        $courses = Course::where('university_id', $universityId)->get();
        return response()->json($courses);
    }

    public function getSubCourses($courseId)
    {
        $subCourses = SubCourse::where('course_id', $courseId)->get();
        return response()->json($subCourses);
    }


    // public function getSubCourseDetails($subCourseId)
    // {
    //     $subCourse = SubCourse::with('courseMode')->find($subCourseId);

    //     if ($subCourse) {
    //         return response()->json([
    //             'course_mode_id'   => $subCourse->course_mode_id ?? ($subCourse->courseMode->id ?? null), // ✅ Added line
    //             'course_mode_name' => $subCourse->courseMode->name ?? '',
    //             'course_duration'  => $subCourse->duration ?? '',
    //             'eligibility' => $subCourse->eligibility, // this is an array from the cast

    //         ]);
    //     }

    //     return response()->json([
    //         'course_mode_id'   => '',
    //         'course_mode_name' => '',
    //         'course_duration'  => ''
    //     ]);
    // }


    public function getSubCourseDetails($subCourseId, Request $request)
    {
        $subCourse = SubCourse::with('courseMode')->find($subCourseId);

        if (!$subCourse) {
            return response()->json([
                'course_mode_id' => '',
                'course_mode_name' => '',
                'course_duration' => '',
                'eligibility' => [],
                'prev_educations' => []
            ]);
        }

        $prevEducations = [];
        if ($request->student_id) {
            $student = \App\Models\Student::find($request->student_id);
            if ($student) {
                $prevEducations = $student->qualifications()->get()->map(function ($q) {
                    return [
                        'qualification' => $q->qualification,
                        'board' => $q->board,
                        'passing_year' => $q->passing_year,
                        'marks' => $q->marks,
                        'result' => $q->result,
                        'document' => $q->document
                    ];
                })->toArray();
            }
        }

        return response()->json([
            'course_mode_id' => $subCourse->course_mode_id ?? ($subCourse->courseMode->id ?? null),
            'course_mode_name' => $subCourse->courseMode->name ?? '',
            'course_duration' => $subCourse->duration ?? '',
            'eligibility' => $subCourse->eligibility ?? [],
            'prev_educations' => $prevEducations
        ]);
    }












    /**
     * Generate a unique Student ID.
     * Example: DEV2025U00123
     */

    // private function generateStudentUniqueId($student)
    // {
    //     $prefix = 'DEV'; // You can change this to your institute’s code
    //     $year   = date('Y');

    //     // Use university short name or ID if available
    //     $universityCode = str_pad($student->university_id, 2, '0', STR_PAD_LEFT);

    //     // Combine components
    //     $uniqueNumber = str_pad($student->id, 5, '0', STR_PAD_LEFT);

    //     return "{$prefix}{$year}U{$universityCode}{$uniqueNumber}";
    // }



    // private function generateStudentUniqueId($student)
    // {
    //     $university = University::find($student->university_id);

    //     // Use university prefix or fallback
    //     $prefix = $university && !empty($university->prefix)
    //         ? strtoupper($university->prefix)
    //         : 'UNI'; // default prefix if not set

    //     // Determine total length of serial digits (default 4 if not set)
    //     $length = $university && $university->length > 0 ? $university->length : 4;

    //     // Get current year
    //     $year = date('Y');

    //     // Get count of existing students for that university
    //     $count = Student::where('university_id', $student->university_id)->count() + 1;

    //     // Pad serial number according to university length
    //     $serial = str_pad($count, $length, '0', STR_PAD_LEFT);

    //     // Final format: PREFIXYEARU000001
    //     return "{$prefix}{$serial}";
    // }


    //     private function generateStudentUniqueId($student)
    // {
    //     $university = University::find($student->university_id);
    //     $prefix = $university && !empty($university->prefix) ? strtoupper($university->prefix) : 'UNI';
    //     $length = $university && $university->length > 0 ? $university->length : 4;

    //     // Get last existing ID for this university
    //     $lastStudent = Student::where('university_id', $student->university_id)
    //         ->where('student_unique_id', 'like', "{$prefix}%")
    //         ->orderBy('student_unique_id', 'desc')
    //         ->first();

    //     if ($lastStudent) {
    //         preg_match('/(\d+)$/', $lastStudent->student_unique_id, $matches);
    //         $number = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
    //     } else {
    //         $number = 1;
    //     }

    //     $serial = str_pad($number, $length, '0', STR_PAD_LEFT);
    //     return "{$prefix}{$serial}";
    // }



    private function generateStudentUniqueId($student)
    {
        $university = University::find($student->university_id);
        $prefix = $university && !empty($university->prefix) ? strtoupper($university->prefix) : 'UNI';
        $length = $university && $university->length > 0 ? $university->length : 4;

        // Get last existing ID globally (no university filter)
        $lastStudent = Student::where('student_unique_id', 'like', "{$prefix}%")
            ->orderBy('student_unique_id', 'desc')
            ->first();

        if ($lastStudent) {
            preg_match('/(\d+)$/', $lastStudent->student_unique_id, $matches);
            $number = isset($matches[1]) ? (int)$matches[1] + 1 : 1;
        } else {
            $number = 1;
        }

        $serial = str_pad($number, $length, '0', STR_PAD_LEFT);
        return "{$prefix}{$serial}";
    }




    public function generateId(Student $student)
    {
        try {
            // Check if student already has UniqueID
            if ($student->student_unique_id) {
                return response()->json([
                    'status' => true,
                    'unique_id' => $student->student_unique_id,
                    'message' => 'Unique ID already exists.'
                ]);
            }

            // Generate new UniqueID
            $student->student_unique_id = $this->generateStudentUniqueId($student);
            $student->save();

            return response()->json([
                'status' => true,
                'unique_id' => $student->student_unique_id,
                'message' => 'Unique ID generated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to generate Unique ID: ' . $e->getMessage()
            ]);
        }
    }




    /**
     * Store a newly created resource in storage.
     */


    // public function store(Request $request)
    // {
    //     // Validate incoming request
    //     $validatedData = $request->validate([
    //         'full_name'         => 'required|string|max:255',
    //         'father_name'       => 'nullable|string|max:255',
    //         'mother_name'       => 'nullable|string|max:255',
    //         'aadhaar_no'        => 'nullable|string|max:20',
    //         'email'             => 'nullable|email|max:255|unique:students,email',
    //         'mobile'            => 'nullable|string|max:20',
    //         'dob'               => 'nullable|date',
    //         'gender'            => 'nullable|in:Male,Female,Other',
    //         'academic_year_id'  => 'required|exists:academic_years,id',
    //         'university_id'     => 'required|exists:universities,id',
    //         'course_type_id'    => 'required|exists:course_types,id',
    //         'course_id'         => 'required|exists:courses,id',
    //         'sub_course_id'     => 'required|exists:sub_courses,id',
    //         'mode_id'           => 'required|exists:admission_modes,id',
    //         'course_mode_id'    => 'required|exists:course_modes,id',
    //         'semester'          => 'nullable|string|max:50',
    //         'course_duration'   => 'nullable|string|max:50',
    //         'language_id'       => 'nullable|exists:languages,id',
    //         'blood_group_id'    => 'nullable|exists:blood_groups,id',
    //         'religion_id'       => 'nullable|exists:religions,id',
    //         'category_id'       => 'nullable|exists:categories,id',
    //         'income'            => 'nullable|numeric|min:0',
    //         'total_fee'         => 'nullable|numeric|min:0',
    //         'permanent_address' => 'nullable|string|max:500',
    //         'current_address'   => 'nullable|string|max:500',
    //         'status'            => 'nullable',
    //     ]);

    //     try {
    //         // Create student record
    //         $student = Student::create([
    //             'full_name'         => $validatedData['full_name'],
    //             'father_name'       => $validatedData['father_name'] ?? null,
    //             'mother_name'       => $validatedData['mother_name'] ?? null,
    //             'aadhaar_no'        => $validatedData['aadhaar_no'] ?? null,
    //             'email'             => $validatedData['email'] ?? null,
    //             'mobile'            => $validatedData['mobile'] ?? null,
    //             'dob'               => $validatedData['dob'] ?? null,
    //             'gender'            => $validatedData['gender'] ?? null,
    //             'academic_year_id'  => $validatedData['academic_year_id'],
    //             'university_id'     => $validatedData['university_id'],
    //             'course_type_id'    => $validatedData['course_type_id'],
    //             'course_id'         => $validatedData['course_id'],
    //             'sub_course_id'     => $validatedData['sub_course_id'],
    //             'admissionmode_id'  => $validatedData['mode_id'],
    //             'course_mode_id'    => $validatedData['course_mode_id'],
    //             'semester'          => $validatedData['semester'] ?? null,
    //             'course_duration'   => $validatedData['course_duration'] ?? null,
    //             'language_id'       => $validatedData['language_id'] ?? null,
    //             'blood_group_id'    => $validatedData['blood_group_id'] ?? null,
    //             'religion_id'       => $validatedData['religion_id'] ?? null,
    //             'category_id'       => $validatedData['category_id'] ?? null,
    //             'income'            => $validatedData['income'] ?? null,
    //             'total_fee'         => $validatedData['total_fee'] ?? null,
    //             'permanent_address' => $validatedData['permanent_address'] ?? null,
    //             'current_address'   => $validatedData['current_address'] ?? null,
    //             'status'            => $validatedData['status'] ?? 1,
    //         ]);

    //         // ✅ Generate unique Student ID after creation
    //         $student->student_unique_id = $this->generateStudentUniqueId($student);
    //         $student->save();

    //         return response()->json([
    //             'status'  => 'success',
    //             'message' => 'Student has been added successfully.',
    //             'data'    => $student
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Something went wrong: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }



    // public function store(Request $request)
    // {
    //     // ----------------------------
    //     // VALIDATION
    //     // ----------------------------
    //     $validatedData = $request->validate([
    //         'full_name'         => 'required|string|max:255',
    //         'father_name'       => 'nullable|string|max:255',
    //         'mother_name'       => 'nullable|string|max:255',
    //         'aadhaar_no'        => 'nullable|string|max:20',
    //         'email'             => 'nullable|email|max:255|unique:students,email',
    //         'mobile'            => 'nullable|string|max:20',
    //         'dob'               => 'nullable|date',
    //         'gender'            => 'nullable|in:Male,Female,Other',
    //         'academic_year_id'  => 'required|exists:academic_years,id',
    //         'university_id'     => 'required|exists:universities,id',
    //         'course_type_id'    => 'required|exists:course_types,id',
    //         'course_id'         => 'required|exists:courses,id',
    //         'sub_course_id'     => 'required|exists:sub_courses,id',
    //         'mode_id'           => 'required|exists:admission_modes,id',
    //         'course_mode_id'    => 'required|exists:course_modes,id',
    //         'semester'          => 'nullable|string|max:50',
    //         'course_duration'   => 'nullable|string|max:50',
    //         'language_id'       => 'nullable|exists:languages,id',
    //         'blood_group_id'    => 'nullable|exists:blood_groups,id',
    //         'religion_id'       => 'nullable|exists:religions,id',
    //         'category_id'       => 'nullable|exists:categories,id',
    //         'income'            => 'nullable|numeric|min:0',
    //         'total_fee'         => 'nullable|numeric|min:0',
    //         'permanent_address' => 'nullable|string|max:500',
    //         'current_address'   => 'nullable|string|max:500',
    //         'status'            => 'nullable',

    //         // --------------------------
    //         // Qualification Validation
    //         // --------------------------
    //         'prev_qualification' => 'nullable|string|max:255',
    //         'prev_board'         => 'nullable|string|max:255',
    //         'prev_passing_year'  => 'nullable|string|max:10',
    //         'prev_marks'         => 'nullable|string|max:50',
    //         'prev_result'        => 'nullable|string|max:20',
    //         'prev_document'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //     ]);

    //     try {

    //         // ----------------------------
    //         // 1. CREATE STUDENT
    //         // ----------------------------
    //         $student = Student::create([
    //             'full_name'         => $validatedData['full_name'],
    //             'father_name'       => $validatedData['father_name'] ?? null,
    //             'mother_name'       => $validatedData['mother_name'] ?? null,
    //             'aadhaar_no'        => $validatedData['aadhaar_no'] ?? null,
    //             'email'             => $validatedData['email'] ?? null,
    //             'mobile'            => $validatedData['mobile'] ?? null,
    //             'dob'               => $validatedData['dob'] ?? null,
    //             'gender'            => $validatedData['gender'] ?? null,
    //             'academic_year_id'  => $validatedData['academic_year_id'],
    //             'university_id'     => $validatedData['university_id'],
    //             'course_type_id'    => $validatedData['course_type_id'],
    //             'course_id'         => $validatedData['course_id'],
    //             'sub_course_id'     => $validatedData['sub_course_id'],
    //             'admissionmode_id'  => $validatedData['mode_id'],
    //             'course_mode_id'    => $validatedData['course_mode_id'],
    //             'semester'          => $validatedData['semester'] ?? null,
    //             'course_duration'   => $validatedData['course_duration'] ?? null,
    //             'language_id'       => $validatedData['language_id'] ?? null,
    //             'blood_group_id'    => $validatedData['blood_group_id'] ?? null,
    //             'religion_id'       => $validatedData['religion_id'] ?? null,
    //             'category_id'       => $validatedData['category_id'] ?? null,
    //             'income'            => $validatedData['income'] ?? null,
    //             'total_fee'         => $validatedData['total_fee'] ?? null,
    //             'permanent_address' => $validatedData['permanent_address'] ?? null,
    //             'current_address'   => $validatedData['current_address'] ?? null,
    //             'status'            => $validatedData['status'] ?? 1,
    //         ]);

    //         // ----------------------------
    //         // 2. Generate Unique ID
    //         // ----------------------------
    //         $student->student_unique_id = $this->generateStudentUniqueId($student);
    //         $student->save();

    //         // ----------------------------
    //         // 3. Upload Qualification Document
    //         // ----------------------------
    //         // $documentPath = null;

    //         // if ($request->hasFile('prev_document')) {
    //         //     $document = $request->file('prev_document');
    //         //     $documentPath = $document->store('qualification_documents', 'public');
    //         // }

    //         // Upload Previous Qualification Document
    //         $documentPath = null;

    //         if ($request->hasFile('prev_document')) {
    //             $file = $request->file('prev_document');

    //             // Create unique filename
    //             $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

    //             // Move file to public/uploads/qualification_documents/
    //             $file->move(public_path('uploads/qualification_documents'), $filename);

    //             // Save file path
    //             $documentPath = 'uploads/qualification_documents/' . $filename;
    //         }


    //         // ----------------------------
    //         // 4. Save Qualification
    //         // ----------------------------
    //         StudentQualification::create([
    //             'student_id'    => $student->id,
    //             'qualification' => $request->prev_qualification,
    //             'board'         => $request->prev_board,
    //             'passing_year'  => $request->prev_passing_year,
    //             'marks'         => $request->prev_marks,
    //             'result'        => $request->prev_result,
    //             'document'      => $documentPath,
    //         ]);

    //         return response()->json([
    //             'status'  => 'success',
    //             'message' => 'Student has been added successfully.',
    //             'data'    => $student
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Something went wrong: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }



    public function store(Request $request)
    {
        // ----------------------------
        // VALIDATION
        // ----------------------------
        $validatedData = $request->validate([
            'full_name'         => 'required|string|max:255',
            'father_name'       => 'nullable|string|max:255',
            'mother_name'       => 'nullable|string|max:255',
            'aadhaar_no'        => 'nullable|string|max:20',
            'email'             => 'nullable|email|max:255|unique:students,email',
            'mobile'            => 'nullable|string|max:20',
            'dob'               => 'nullable|date',
            'gender'            => 'nullable|in:Male,Female,Other',
            'academic_year_id'  => 'required|exists:academic_years,id',
            'university_id'     => 'required|exists:universities,id',
            'course_type_id'    => 'required|exists:course_types,id',
            'course_id'         => 'required|exists:courses,id',
            'sub_course_id'     => 'required|exists:sub_courses,id',
            'mode_id'           => 'required|exists:admission_modes,id',
            'course_mode_id'    => 'required|exists:course_modes,id',
            'semester'          => 'nullable|string|max:50',
            'course_duration'   => 'nullable|string|max:50',
            'language_id'       => 'nullable|exists:languages,id',
            'blood_group_id'    => 'nullable|exists:blood_groups,id',
            'religion_id'       => 'nullable|exists:religions,id',
            'category_id'       => 'nullable|exists:categories,id',
            'income'            => 'nullable|numeric|min:0',
            'total_fee'         => 'nullable|numeric|min:0',
            'permanent_address' => 'nullable|string|max:500',
            'current_address'   => 'nullable|string|max:500',
            'status'            => 'nullable',

            // --------------------------
            // Qualification Validation (Arrays)
            // --------------------------
            'prev_qualification' => 'nullable|array',
            'prev_board'         => 'nullable|array',
            'prev_passing_year'  => 'nullable|array',
            'prev_marks'         => 'nullable|array',
            'prev_result'        => 'nullable|array',
            'prev_document.*'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {

            // ----------------------------
            // 1. CREATE STUDENT
            // ----------------------------
            $student = Student::create([
                'full_name'         => $validatedData['full_name'],
                'father_name'       => $validatedData['father_name'] ?? null,
                'mother_name'       => $validatedData['mother_name'] ?? null,
                'aadhaar_no'        => $validatedData['aadhaar_no'] ?? null,
                'email'             => $validatedData['email'] ?? null,
                'mobile'            => $validatedData['mobile'] ?? null,
                'dob'               => $validatedData['dob'] ?? null,
                'gender'            => $validatedData['gender'] ?? null,
                'academic_year_id'  => $validatedData['academic_year_id'],
                'university_id'     => $validatedData['university_id'],
                'course_type_id'    => $validatedData['course_type_id'],
                'course_id'         => $validatedData['course_id'],
                'sub_course_id'     => $validatedData['sub_course_id'],
                'admissionmode_id'  => $validatedData['mode_id'],
                'course_mode_id'    => $validatedData['course_mode_id'],
                'semester'          => $validatedData['semester'] ?? null,
                'course_duration'   => $validatedData['course_duration'] ?? null,
                'language_id'       => $validatedData['language_id'] ?? null,
                'blood_group_id'    => $validatedData['blood_group_id'] ?? null,
                'religion_id'       => $validatedData['religion_id'] ?? null,
                'category_id'       => $validatedData['category_id'] ?? null,
                'income'            => $validatedData['income'] ?? null,
                'total_fee'         => $validatedData['total_fee'] ?? null,
                'permanent_address' => $validatedData['permanent_address'] ?? null,
                'current_address'   => $validatedData['current_address'] ?? null,
                'status'            => $validatedData['status'] ?? 1,
            ]);

            // ----------------------------
            // 2. Generate Unique ID
            // ----------------------------
            $student->student_unique_id = $this->generateStudentUniqueId($student);
            $student->save();

            // ----------------------------
            // 3. SAVE MULTIPLE QUALIFICATIONS
            // ----------------------------
            $qualifications = $request->prev_qualification ?? [];
            $boards         = $request->prev_board ?? [];
            $years          = $request->prev_passing_year ?? [];
            $marks          = $request->prev_marks ?? [];
            $results        = $request->prev_result ?? [];
            $documents      = $request->file('prev_document') ?? [];

            foreach ($qualifications as $i => $qualification) {

                // Upload document if exists
                $documentPath = null;
                if (isset($documents[$i]) && $documents[$i]) {
                    $file = $documents[$i];
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/qualification_documents'), $filename);
                    $documentPath = 'uploads/qualification_documents/' . $filename;
                }

                StudentQualification::create([
                    'student_id'    => $student->id,
                    'qualification' => $qualification,
                    'board'         => $boards[$i] ?? null,
                    'passing_year'  => $years[$i] ?? null,
                    'marks'         => $marks[$i] ?? null,
                    'result'        => $results[$i] ?? null,
                    'document'      => $documentPath,
                ]);
            }




            // -----------------------------------------------------
            // 4. SAVE REQUIRED DOCUMENTS (Single + Multiple Upload)
            // -----------------------------------------------------

            $requiredDocuments = $request->documents ?? [];  // Uploaded files
            $docMeta           = $request->doc_meta ?? [];   // Hidden metadata fields

            foreach ($docMeta as $docId => $meta) {

                // ---- Metadata Fields ----
                $docName         = $meta['name'] ?? '';
                $maxSize         = $meta['max_size'] ?? null;
                $acceptableTypes = $meta['acceptable_type'] ?? '[]';
                $isRequired      = $meta['is_required'] ?? 0;
                $isMultiple      = $meta['is_multiple'] ?? 0;

                // ---- Check Required Document ----
                if ($isRequired && empty($requiredDocuments[$docId])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Required document missing: $docName"
                    ], 422);
                }

                // ---- Skip if no upload ----
                if (empty($requiredDocuments[$docId])) {
                    continue;
                }

                $files = $requiredDocuments[$docId];

                // -------------------------------------------------------
                // MULTIPLE UPLOAD MODE
                // -------------------------------------------------------
                if ($isMultiple == 1) {

                    // Ensure it's always treated as an array
                    if (!is_array($files)) {
                        $files = [$files];
                    }

                    $storedFiles = [];

                    foreach ($files as $file) {

                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads/student_documents'), $fileName);

                        $storedFiles[] = 'uploads/student_documents/' . $fileName;
                    }

                    // Store JSON file paths
                    StudentDocument::create([
                        'student_id'       => $student->id,
                        'document_id'      => $docId,
                        'path'            => $storedFiles,  // JSON array

                    ]);
                }

                // -------------------------------------------------------
                // SINGLE UPLOAD MODE
                // -------------------------------------------------------
                else {

                    $file = is_array($files) ? $files[0] : $files;

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/student_documents'), $fileName);

                    StudentDocument::create([
                        'student_id'       => $student->id,
                        'document_id'      => $docId,
                        'path'             => 'uploads/student_documents/' . $fileName,

                    ]);
                }
            }



            return response()->json([
                'status'  => 'success',
                'message' => 'Student has been added successfully.',
                'data'    => $student
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }




    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     // $student = Student::findOrFail($id);
    //     $student = Student::with('qualifications')->findOrFail($id);


    //     // Load related data for select fields
    //     $academicYears = AcademicYear::all();
    //     $universities = University::all();
    //     $courseTypes  = CourseType::all();
    //     $courses      = Course::all();
    //     $subCourses   = SubCourse::all();
    //     $modes        = AdmissionMode::all();
    //     $courseModes  = CourseMode::all();
    //     $languages    = Language::all();
    //     $bloodGroups  = BloodGroup::all();
    //     $religions    = Religion::all();
    //     $categories   = Category::all();

    //     return view('students.view', compact(
    //         'student',
    //         'academicYears',
    //         'universities',
    //         'courseTypes',
    //         'courses',
    //         'subCourses',
    //         'modes',
    //         'courseModes',
    //         'languages',
    //         'bloodGroups',
    //         'religions',
    //         'categories'
    //     ));
    // }


    public function show($id)
    {
        $student = Student::with([
            'qualifications',
            'studentDocuments.document'  // FIXED HERE
        ])->findOrFail($id);

        // Load related data
        $academicYears = AcademicYear::all();
        $universities = University::all();
        $courseTypes  = CourseType::all();
        $courses      = Course::all();
        $subCourses   = SubCourse::all();
        $modes        = AdmissionMode::all();
        $courseModes  = CourseMode::all();
        $languages    = Language::all();
        $bloodGroups  = BloodGroup::all();
        $religions    = Religion::all();
        $categories   = Category::all();

        return view('students.view', compact(
            'student',
            'academicYears',
            'universities',
            'courseTypes',
            'courses',
            'subCourses',
            'modes',
            'courseModes',
            'languages',
            'bloodGroups',
            'religions',
            'categories'
        ));
    }



    public function print($id)
    {
        $student = Student::findOrFail($id);

        return view('students.print', compact('student'));
    }

    public function pdf($id)
    {
        $student = Student::findOrFail($id);

        $pdf = Pdf::loadView('students.print', compact('student'))
            ->setPaper('A4', 'portrait');

        return $pdf->download($student->full_name . '_details.pdf');
    }



    public function generateIdCardPDF($id)
    {
        $student = Student::with(['course', 'academicYear', 'bloodGroup', 'university'])->findOrFail($id);

        $pdf = Pdf::loadView('students.idcardpdf', compact('student'))
            ->setPaper([0, 0, 350, 220], 'landscape'); // ID card size

        return $pdf->download($student->full_name . '_IDCard.pdf');
    }


    //     public function idCard($id)
    // {
    //     $student = Student::findOrFail($id);

    //     $pdf = Pdf::loadView('students.idcard', compact('student'))
    //               ->setPaper([0, 0, 350, 220], 'landscape'); // small ID card size

    //     return $pdf->download($student->full_name . '_IDCard.pdf');
    // }


    // public function idCard($id)
    // {
    //     $student = Student::findOrFail($id);

    //     // Set standard ID card size (landscape mode)
    //     $pdf = Pdf::loadView('students.idcard', compact('student'))
    //               ->setPaper([0, 0, 340, 220], 'landscape'); // Professional card size

    //     return $pdf->download($student->full_name . '_IDCard.pdf');
    // }


    public function idcard($id)
    {
        $student = Student::with(['university', 'course', 'academicYear', 'bloodGroup'])->findOrFail($id);
        return view('students.idcard', compact('student'));
    }


    //     public function idcard($id)
    // {
    //     $student = Student::with(['university', 'course', 'academicYear', 'bloodGroup'])->findOrFail($id);

    //     // Generate QR code with student ID and name (you can customize data)
    //     $qrCode = base64_encode(QrCode::format('png')
    //                   ->size(100)
    //                   ->generate("ID: {$student->id}, Name: {$student->full_name}"));

    //     return view('students.idcard', compact('student', 'qrCode'));
    // }

    // public function idcard($id)
    // {
    //     $student = Student::with(['university', 'course', 'academicYear', 'bloodGroup'])->findOrFail($id);

    //     $qrData = [
    //         'name' => $student->full_name,
    //         'id' => $student->id,
    //         'admissionNo' => $student->admission_no,
    //         'course' => $student->course->name,
    //         'university' => $student->university->name,
    //         'email' => $student->email,
    //         'mobile' => $student->mobile
    //     ];

    //     $qrCode = QrCode::size(120)->generate(json_encode($qrData));

    //     return view('students.idcard', compact('student', 'qrCode'));
    // }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    /**
     * Show the form for editing the specified resource.
     */

    // public function edit($id)
    // {
    //     $student = Student::findOrFail($id);
    //     $academicYears = AcademicYear::all();
    //     $universities = University::all();
    //     $courseTypes = CourseType::all();
    //     $courses = Course::all();
    //     $subCourses = SubCourse::all();
    //     $modes = AdmissionMode::all();
    //     $courseModes = CourseMode::all();
    //     $languages = Language::all();
    //     $bloodGroups = BloodGroup::all();
    //     $religions = Religion::all();
    //     $categories = Category::all();

    //     return view('students.edit', compact(
    //         'student',
    //         'academicYears',
    //         'universities',
    //         'courseTypes',
    //         'courses',
    //         'subCourses',
    //         'modes',
    //         'courseModes',
    //         'languages',
    //         'bloodGroups',
    //         'religions',
    //         'categories'
    //     ));
    // }



    //     public function getStudentQualifications($id)
    // {
    //     try {
    //         $student = Student::findOrFail($id);
    //         $qualifications = $student->qualifications()->get()->map(function ($q) {
    //             return [
    //                 'qualification' => $q->qualification,
    //                 'board' => $q->board,
    //                 'passing_year' => $q->passing_year,
    //                 'marks' => $q->marks,
    //                 'result' => $q->result,
    //                 'document' => $q->document
    //             ];
    //         })->toArray();

    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $qualifications
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    public function getStudentQualifications($id)
    {
        try {
            $student = Student::with('qualifications')->findOrFail($id);

            $qualifications = $student->qualifications->map(function ($q) {
                return [
                    'qualification' => $q->qualification,
                    'board' => $q->board,
                    'passing_year' => $q->passing_year,
                    'marks' => $q->marks,
                    'result' => $q->result,
                    'document' => $q->document
                ];
            })->toArray();

            return response()->json([
                'status' => 'success',
                'data' => $qualifications
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to get student qualifications: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getStudentDocuments($id)
    {
        try {
            $studentDocuments = StudentDocument::with('document')
                ->where('student_id', $id)
                ->get()
                ->map(function ($sd) {
                    return [
                        'document_id' => $sd->document_id,
                        'path' => $sd->path,
                        'document_name' => $sd->document->name ?? 'Unknown'
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => $studentDocuments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        // $student = Student::findOrFail($id);
        $student = Student::with([
            'qualifications',
            'studentDocuments.document',
            'university'
        ])->findOrFail($id);
        $academicYears = AcademicYear::all();
        $universities = University::all();
        $courseTypes = CourseType::all();
        $courses = Course::all();
        $subCourses = SubCourse::all();
        $modes = AdmissionMode::all();
        $courseModes = CourseMode::all();
        $languages = Language::all();
        $bloodGroups = BloodGroup::all();
        $religions = Religion::all();
        $categories = Category::all();

        // Get the selected sub-course to access eligibility directly
        $selectedSubCourse = $student->sub_course_id
            ? SubCourse::find($student->sub_course_id)
            : null;

        // Get student qualifications (previous education)
        $studentQualifications = $student->qualifications()->get(); // Assuming a hasMany relation in Student model

        return view('students.edit', compact(
            'student',
            'academicYears',
            'universities',
            'courseTypes',
            'courses',
            'subCourses',
            'modes',
            'courseModes',
            'languages',
            'bloodGroups',
            'religions',
            'categories',
            'selectedSubCourse',   // SubCourse eligibility
            'studentQualifications' // Student's saved qualifications
        ));
    }




    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     // Find the student or fail
    //     $student = Student::findOrFail($id);

    //     // Validate request
    //     $validatedData = $request->validate([
    //         'full_name'         => 'required|string|max:255',
    //         'father_name'       => 'nullable|string|max:255',
    //         'mother_name'       => 'nullable|string|max:255',
    //         'aadhaar_no'        => 'nullable|string|max:20',
    //         'email'             => 'nullable|email|max:255|unique:students,email,' . $student->id,
    //         'mobile'            => 'nullable|string|max:20',
    //         'dob'               => 'nullable|date',
    //         'gender'            => 'nullable|in:Male,Female,Other',
    //         'academic_year_id'  => 'required|exists:academic_years,id',
    //         'university_id'     => 'required|exists:universities,id',
    //         'course_type_id'    => 'required|exists:course_types,id',
    //         'course_id'         => 'required|exists:courses,id',
    //         'sub_course_id'     => 'required|exists:sub_courses,id',
    //         'mode_id'           => 'required|exists:admission_modes,id',
    //         'course_mode_id'    => 'required|exists:course_modes,id',
    //         'semester'          => 'nullable|string|max:50',
    //         'course_duration'   => 'nullable|string|max:50',
    //         'language_id'       => 'nullable|exists:languages,id',
    //         'blood_group_id'    => 'nullable|exists:blood_groups,id',
    //         'religion_id'       => 'nullable|exists:religions,id',
    //         'category_id'       => 'nullable|exists:categories,id',
    //         'income'            => 'nullable|numeric|min:0',
    //         'total_fee'         => 'nullable|numeric|min:0',
    //         'permanent_address' => 'nullable|string|max:500',
    //         'current_address'   => 'nullable|string|max:500',
    //         'status'            => 'nullable',
    //     ]);

    //     try {
    //         // Update student
    //         $student->update([
    //             'full_name'         => $validatedData['full_name'],
    //             'father_name'       => $validatedData['father_name'] ?? null,
    //             'mother_name'       => $validatedData['mother_name'] ?? null,
    //             'aadhaar_no'        => $validatedData['aadhaar_no'] ?? null,
    //             'email'             => $validatedData['email'] ?? null,
    //             'mobile'            => $validatedData['mobile'] ?? null,
    //             'dob'               => $validatedData['dob'] ?? null,
    //             'gender'            => $validatedData['gender'] ?? null,
    //             'academic_year_id'  => $validatedData['academic_year_id'],
    //             'university_id'     => $validatedData['university_id'],
    //             'course_type_id'    => $validatedData['course_type_id'],
    //             'course_id'         => $validatedData['course_id'],
    //             'sub_course_id'     => $validatedData['sub_course_id'],
    //             'admissionmode_id'  => $validatedData['mode_id'], // ✅ Fixed column name
    //             'course_mode_id'    => $validatedData['course_mode_id'],
    //             'semester'          => $validatedData['semester'] ?? null,
    //             'course_duration'   => $validatedData['course_duration'] ?? null,
    //             'language_id'       => $validatedData['language_id'] ?? null,
    //             'blood_group_id'    => $validatedData['blood_group_id'] ?? null,
    //             'religion_id'       => $validatedData['religion_id'] ?? null,
    //             'category_id'       => $validatedData['category_id'] ?? null,
    //             'income'            => $validatedData['income'] ?? null,
    //             'total_fee'         => $validatedData['total_fee'] ?? null,
    //             'permanent_address' => $validatedData['permanent_address'] ?? null,
    //             'current_address'   => $validatedData['current_address'] ?? null,
    //             'status'            => $validatedData['status'] ?? 1,
    //         ]);

    //         return response()->json([
    //             'status'  => 'success',
    //             'message' => 'Student has been updated successfully.',
    //             'data'    => $student
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Something went wrong: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }



    public function update(Request $request, $id)
    {
        // Find the student or fail
        $student = Student::findOrFail($id);

        // Validate request - BASIC FIELDS
        $validatedData = $request->validate([
            'full_name'         => 'required|string|max:255',
            'father_name'       => 'nullable|string|max:255',
            'mother_name'       => 'nullable|string|max:255',
            'aadhaar_no'        => 'nullable|string|max:20',
            'email'             => 'nullable|email|max:255|unique:students,email,' . $student->id,
            'mobile'            => 'nullable|string|max:20',
            'dob'               => 'nullable|date',
            'gender'            => 'nullable|in:Male,Female,Other',
            'academic_year_id'  => 'required|exists:academic_years,id',
            'university_id'     => 'required|exists:universities,id',
            'course_type_id'    => 'required|exists:course_types,id',
            'course_id'         => 'required|exists:courses,id',
            'sub_course_id'     => 'required|exists:sub_courses,id',
            'mode_id'           => 'required|exists:admission_modes,id',
            'course_mode_id'    => 'required|exists:course_modes,id',
            'semester'          => 'nullable|string|max:50',
            'course_duration'   => 'nullable|string|max:50',
            'language_id'       => 'nullable|exists:languages,id',
            'blood_group_id'    => 'nullable|exists:blood_groups,id',
            'religion_id'       => 'nullable|exists:religions,id',
            'category_id'       => 'nullable|exists:categories,id',
            'income'            => 'nullable|numeric|min:0',
            'total_fee'         => 'nullable|numeric|min:0',
            'permanent_address' => 'nullable|string|max:500',
            'current_address'   => 'nullable|string|max:500',
            'status'            => 'nullable',

            // Qualification validation
            'prev_qualification' => 'nullable|array',
            'prev_board'         => 'nullable|array',
            'prev_passing_year'  => 'nullable|array',
            'prev_marks'         => 'nullable|array',
            'prev_result'        => 'nullable|array',
            'prev_document.*'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Document validation - only validate if files are actually uploaded
            'delete_documents' => 'nullable|array',
            'existing_documents' => 'nullable|array',
        ]);

        // Custom validation for documents - only validate actual uploaded files
        $validator = Validator::make($request->all(), [
            'documents.*.*' => 'sometimes|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Update student
            $student->update([
                'full_name'         => $validatedData['full_name'],
                'father_name'       => $validatedData['father_name'] ?? null,
                'mother_name'       => $validatedData['mother_name'] ?? null,
                'aadhaar_no'        => $validatedData['aadhaar_no'] ?? null,
                'email'             => $validatedData['email'] ?? null,
                'mobile'            => $validatedData['mobile'] ?? null,
                'dob'               => $validatedData['dob'] ?? null,
                'gender'            => $validatedData['gender'] ?? null,
                'academic_year_id'  => $validatedData['academic_year_id'],
                'university_id'     => $validatedData['university_id'],
                'course_type_id'    => $validatedData['course_type_id'],
                'course_id'         => $validatedData['course_id'],
                'sub_course_id'     => $validatedData['sub_course_id'],
                'admissionmode_id'  => $validatedData['mode_id'],
                'course_mode_id'    => $validatedData['course_mode_id'],
                'semester'          => $validatedData['semester'] ?? null,
                'course_duration'   => $validatedData['course_duration'] ?? null,
                'language_id'       => $validatedData['language_id'] ?? null,
                'blood_group_id'    => $validatedData['blood_group_id'] ?? null,
                'religion_id'       => $validatedData['religion_id'] ?? null,
                'category_id'       => $validatedData['category_id'] ?? null,
                'income'            => $validatedData['income'] ?? null,
                'total_fee'         => $validatedData['total_fee'] ?? null,
                'permanent_address' => $validatedData['permanent_address'] ?? null,
                'current_address'   => $validatedData['current_address'] ?? null,
                'status'            => $validatedData['status'] ?? 1,
            ]);

            // Handle qualification updates
            if ($request->has('prev_qualification')) {
                // Delete existing qualifications
                StudentQualification::where('student_id', $student->id)->delete();

                $qualifications = $request->prev_qualification ?? [];
                $boards = $request->prev_board ?? [];
                $years = $request->prev_passing_year ?? [];
                $marks = $request->prev_marks ?? [];
                $results = $request->prev_result ?? [];
                $documents = $request->file('prev_document') ?? [];

                foreach ($qualifications as $i => $qualification) {
                    $documentPath = null;

                    // Check if there's a new file upload for this qualification
                    if (isset($documents[$i]) && $documents[$i]) {
                        $file = $documents[$i];
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads/qualification_documents'), $filename);
                        $documentPath = 'uploads/qualification_documents/' . $filename;
                    }

                    StudentQualification::create([
                        'student_id' => $student->id,
                        'qualification' => $qualification,
                        'board' => $boards[$i] ?? null,
                        'passing_year' => $years[$i] ?? null,
                        'marks' => $marks[$i] ?? null,
                        'result' => $results[$i] ?? null,
                        'document' => $documentPath,
                    ]);
                }
            }

            // Handle document deletion
            if ($request->delete_documents) {
                foreach ($request->delete_documents as $docId => $fileIndexes) {
                    $studentDoc = StudentDocument::where('student_id', $student->id)
                        ->where('document_id', $docId)
                        ->first();

                    if ($studentDoc) {
                        $paths = is_array($studentDoc->path) ? $studentDoc->path : [$studentDoc->path];

                        foreach ($fileIndexes as $index) {
                            if (isset($paths[$index])) {
                                // Delete physical file
                                if (file_exists(public_path($paths[$index]))) {
                                    unlink(public_path($paths[$index]));
                                }
                                // Remove from array
                                unset($paths[$index]);
                            }
                        }

                        // Update or delete the record
                        if (empty($paths)) {
                            $studentDoc->delete();
                        } else {
                            $studentDoc->update(['path' => array_values($paths)]);
                        }
                    }
                }
            }

            // Handle new document uploads - only process actual uploaded files
            if ($request->documents) {
                foreach ($request->documents as $docId => $files) {
                    // Skip if no files were uploaded for this document
                    if (empty($files) || (is_array($files) && empty(array_filter($files)))) {
                        continue;
                    }

                    $docMeta = $request->doc_meta[$docId] ?? null;
                    if (!$docMeta) continue;

                    $isMultiple = $docMeta['is_multiple'] ?? 0;

                    if ($isMultiple == 1 && is_array($files)) {
                        // Multiple files - filter out empty values
                        $files = array_filter($files);
                        if (empty($files)) continue;

                        $storedFiles = [];
                        foreach ($files as $file) {
                            if ($file && $file->isValid()) {
                                $fileName = time() . '_' . $file->getClientOriginalName();
                                $file->move(public_path('uploads/student_documents'), $fileName);
                                $storedFiles[] = 'uploads/student_documents/' . $fileName;
                            }
                        }

                        if (!empty($storedFiles)) {
                            // Get existing files if any
                            $existingDoc = StudentDocument::where('student_id', $student->id)
                                ->where('document_id', $docId)
                                ->first();

                            if ($existingDoc) {
                                $existingPaths = is_array($existingDoc->path) ? $existingDoc->path : [$existingDoc->path];
                                $allPaths = array_merge($existingPaths, $storedFiles);
                                $existingDoc->update(['path' => $allPaths]);
                            } else {
                                StudentDocument::create([
                                    'student_id' => $student->id,
                                    'document_id' => $docId,
                                    'path' => $storedFiles,
                                ]);
                            }
                        }
                    } else {
                        // Single file - check if file is valid
                        $file = is_array($files) ? $files[0] : $files;

                        if ($file && $file->isValid()) {
                            $fileName = time() . '_' . $file->getClientOriginalName();
                            $file->move(public_path('uploads/student_documents'), $fileName);

                            StudentDocument::updateOrCreate(
                                [
                                    'student_id' => $student->id,
                                    'document_id' => $docId,
                                ],
                                [
                                    'path' => 'uploads/student_documents/' . $fileName,
                                ]
                            );
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Student has been updated successfully.',
                'data'    => $student
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Student update error: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function updateStatus($id, Request $request)
    {
        // dd($request->all());
        try {
            $student = \App\Models\Student::findOrFail($id);
            $student->status_id = $request->status_id;
            $student->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Student status updated successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage(),
            ]);
        }
    }
}
