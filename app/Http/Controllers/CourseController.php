<?php

namespace App\Http\Controllers;

use App\Models\Academics\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Academics\Department;
use App\Models\Academics\CourseType;
use App\Models\Settings\CourseType as SettingsCourseType;
use App\Models\Academics\University;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Load related department and course type
            $courses = Course::with(['department', 'courseType'])->orderBy('id', 'desc')->get();

            return DataTables::of($courses)
                ->addIndexColumn()
                ->addColumn('university', function ($course) {
                    return $course->university->name ?? '-';
                })
                ->addColumn('department', function ($course) {
                    return $course->department->name ?? '-';
                })
                ->addColumn('course_type', function ($course) {
                    return $course->courseType->name ?? '-';
                })
                ->editColumn('status', function ($course) {
                    return $course->status ? 1 : 0;
                })
                ->addColumn('action', function ($course) {
                    return '';
                })
                ->make(true);
        }

        return view('academics.course.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('status', 1)->get();
        $courseTypes = SettingsCourseType::where('status', 1)->get();
        $universities = University::where('status', 1)->get();
        return view('academics.course.create', compact('departments', 'courseTypes', 'universities'));
    }


    public function getDepartmentsByUniversity($id)
    {
        $departments = Department::where('university_id', $id)
            ->where('status', 1)
            ->get(['id', 'name']);

        return response()->json($departments);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'university_id' => 'required|exists:universities,id',
            'course_type_id' => 'required|exists:departments,id', // Fixed validation
            'name' => 'required|string|max:100',
            'short_name' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Image validation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $data = [
            'department_id' => $request->department_id,
            'university_id' => $request->university_id,
            'course_type_id' => $request->course_type_id,
            'name' => $request->name,
            'short_name' => $request->short_name,
            'status' => $request->input('status', 1),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/courses'), $imageName);
            $data['image'] = 'uploads/courses/' . $imageName;
        }

        $course = Course::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Course added successfully!',
            'data' => $course
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $departments = Department::where('status', 1)->get();
        $courseTypes = SettingsCourseType::where('status', 1)->get();
        $universities = University::where('status', 1)->get();
        return view('academics.course.edit', compact('course', 'departments', 'courseTypes','universities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the course
        $course = Course::findOrFail($id);

        // Validate request
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'university_id' => 'required|exists:universities,id',
            'course_type_id' => 'required|exists:departments,id', // corrected validation
            'name' => 'required|string|max:100',
            'short_name' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Prepare data for update
        $data = [
            'department_id' => $request->department_id,
            'university_id' => $request->university_id,
            'course_type_id' => $request->course_type_id,
            'name' => $request->name,
            'short_name' => $request->short_name,
            'status' => $request->input('status', 1),
        ];

        // Handle image upload and replacement
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image && file_exists(public_path($course->image))) {
                unlink(public_path($course->image));
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/courses'), $imageName);
            $data['image'] = 'uploads/courses/' . $imageName;
        }

        // Update course
        $course->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Course updated successfully!',
            'data' => $course
        ], 200); // 200 OK
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId)
    { {
            try {
                $course = Course::destroy($courseId);
                return ['status' => 'success', 'message' => 'Course deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $course = Course::findOrFail($id);
            if ($course) {
                $course->status = $course->status == 1 ? 0 : 1;
                $course->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $course->name . ' status updated successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Course not found',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getCourseByUniversityAndCourseType(Request $request)
    {
        try {
            $departments = Department::where('university_id', $request->universityId)->pluck('id');
            $courses = Course::where('course_type_id', $request->courseType)->whereIn('department_id', $departments)->get();
            return response()->json([
                'status' => 'success',
                'message' => $courses
            ]);
            // $courses = Course::where('univer')
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
