<?php

namespace App\Http\Controllers;

use App\Models\Academics\Course;
use App\Models\Academics\SubCourse;
use App\Models\Academics\University;
use Illuminate\Http\Request;
use App\Models\Settings\CourseMode;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class SubCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Load related department and course type
            $courses = SubCourse::with(['course', 'courseMode'])->orderBy('id', 'desc')->get();


            // dd($courses);

            // return DataTables::of($courses)
            //     ->addIndexColumn()
            //     ->addColumn('course', function ($course) {
            //         return $course->course->name ?? '-';
            //     })
            //     ->addColumn('courseMode', function($course){
            //         return $course->courseMode->name ?? '-';
            //     })

            //     ->editColumn('status', function ($course) {
            //         return $course->status ? 1 : 0;
            //     })
            //     ->addColumn('action', function ($course) {
            //         return '';
            //     })
            //     ->make(true);

            return DataTables::of($courses)
                ->addIndexColumn()
                ->addColumn('university', fn($course) => $course->university->name ?? '-')
                ->addColumn('course', fn($course) => $course->course->name ?? '-')
                ->addColumn('mode', fn($course) => $course->courseMode->name ?? '-') // key = mode
                ->editColumn('status', fn($course) => $course->status ? 1 : 0)
                ->addColumn('action', fn($course) => '')
                ->make(true);
        }

        return view('academics.subcourse.index');
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses  = Course::where('status', 1)->get();
        $courseModes  = CourseMode::where('status', 1)->get();
        $universities = University::where('status', 1)->get();
        return view('academics.subcourse.create', compact('courses', 'courseModes', 'universities'));
    }
    public function getCoursesByUniversity($id)
    {
        // dd($id);
        $courses = Course::where('university_id', $id)
            ->where('status', 1)
            ->get(['id', 'name']);

        return response()->json($courses);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'mode_id'   => 'required|exists:course_modes,id',
            'name' => 'required|string|max:100',
            'short_name' => 'required|string|max:50',
            'university_fee' => 'nullable|string|max:50',
            'university_id' => 'required|exists:universities,id',
            'duration'  => 'required|string|max:100',
            'eligibility'      => 'required|array',          // ✅ Must be an array
            'eligibility.*'    => 'string|max:255',          // ✅ Each item must be string
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $data = [
            'course_id' => $request->course_id,
            'university_id' => $request->university_id,
            'mode_id'   => $request->mode_id,
            'name' => $request->name,
            'short_name' => $request->short_name,
            'duration'  => $request->duration,
            'university_fee' => $request->university_fee,
            'eligibility'    => $request->eligibility,       // ✅ Save array directly (cast handled in model)
            'status' => $request->input('status', 1),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $image->move(public_path('uploads/subcourses'), $imageName);
            $data['image'] = 'uploads/subcourses/' . $imageName;
        }

        $subCourse = SubCourse::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Sub Course added successfully!',
            'data' => $subCourse
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(SubCourse $subCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($subCourseID)
    {
        $subcourse  = SubCourse::findOrFail($subCourseID);
        $courses  = Course::where('status', 1)->get();
        $courseModes = CourseMode::where('status', 1)->get(); // Pass course modes to view
        $universities = University::where('status', 1)->get();
        // dd($subcourse);

        return view('academics.subcourse.edit', compact('subcourse', 'courses', 'courseModes', 'universities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subcourse = SubCourse::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'mode_id'   => 'required|exists:course_modes,id', // Validate mode
            'name' => 'required|string|max:100',
            'short_name' => 'required|string|max:50',
            'duration'  => 'required|string|max:100',         // Validate duration
            'university_fee' => 'nullable|string|max:50',
            'university_id' => 'required|exists:universities,id',
            'eligibility' => 'required|array',        // ✅ Validate array
            'eligibility.*' => 'string|max:255',      // ✅ Each item string
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $subcourse->course_id = $request->course_id;
        $subcourse->mode_id    = $request->mode_id;    // Save mode
        $subcourse->name = $request->name;
        $subcourse->short_name = $request->short_name;
        $subcourse->university_fee = $request->university_fee;
        $subcourse->university_id = $request->university_id;
        $subcourse->duration   = $request->duration;  // Save duration


        // ✅ Handle eligibility
        $subcourse->eligibility = $request->eligibility;


        // Handle new image
        if ($request->hasFile('image')) {
            if ($subcourse->image && file_exists(public_path($subcourse->image))) {
                unlink(public_path($subcourse->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $image->move(public_path('uploads/subcourses'), $imageName);
            $subcourse->image = 'uploads/subcourses/' . $imageName;
        }

        $subcourse->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sub Course updated successfully!',
            'data' => $subcourse
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subCourseID)
    { {
            try {
                $subcourse = SubCourse::destroy($subCourseID);
                return ['status' => 'success', 'message' => 'subcourse deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $subcourse = SubCourse::findOrFail($id);
            if ($subcourse) {
                $subcourse->status = $subcourse->status == 1 ? 0 : 1;
                $subcourse->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $subcourse->name . ' status updated successfully!',
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

    public function getSubCourseByCourseId(Request $request)
    {
        try {
            $subCourse = SubCourse::where('course_id', $request->courseId)->get();
            return response()->json([
                'status' => 'success',
                'message' => $subCourse
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
