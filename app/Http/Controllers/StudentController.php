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
use App\Models\Settings\Status;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */



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
                ->addColumn('status', fn($row) => $row->status?->name ?? '-') // ✅ status_id column now used
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

                    // // 🔍 Filter by Status
                    // if (isset($request->columns[15]['search']['value']) && $request->columns[15]['search']['value'] !== '') {
                    //     $query->where('status', $request->columns[15]['search']['value']);
                    // }
                    // 🔍 Filter by Status (status_id)
                    if (!empty($request->columns[15]['search']['value'])) {
                        $query->where('status_id', $request->columns[15]['search']['value']);
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








    /**
     * Generate a unique Student ID.
     * Example: DEV2025U00123
     */
    private function generateStudentUniqueId($student)
    {
        $prefix = 'DEV'; // You can change this to your institute’s code
        $year   = date('Y');

        // Use university short name or ID if available
        $universityCode = str_pad($student->university_id, 2, '0', STR_PAD_LEFT);

        // Combine components
        $uniqueNumber = str_pad($student->id, 5, '0', STR_PAD_LEFT);

        return "{$prefix}{$year}U{$universityCode}{$uniqueNumber}";
    }


    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // Validate incoming request
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
        ]);

        try {
            // Create student record
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

            // ✅ Generate unique Student ID after creation
    $student->student_unique_id = $this->generateStudentUniqueId($student);
$student->save();

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
    public function show($id)
    {
        $student = Student::findOrFail($id);

        // Load related data for select fields
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

    public function edit($id)
    {
        $student = Student::findOrFail($id);
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
            'categories'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the student or fail
        $student = Student::findOrFail($id);

        // Validate request
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
        ]);

        try {
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
                'admissionmode_id'  => $validatedData['mode_id'], // ✅ Fixed column name
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

            return response()->json([
                'status'  => 'success',
                'message' => 'Student has been updated successfully.',
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
