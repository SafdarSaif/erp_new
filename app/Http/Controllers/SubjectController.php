<?php

namespace App\Http\Controllers;

use App\Models\Academics\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Academics\SubCourse;
use Illuminate\Support\Facades\Validator;
use Exception;


class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Load related department and subcourse
            $subjects = Subject::with(['subcourse'])->orderBy('id', 'desc')->get();

            return DataTables::of($subjects)
                ->addIndexColumn()
                ->addColumn('subcourse', function ($subjects) {
                    return $subjects->subcourse->name ?? '-';
                })

                ->editColumn('status', function ($subjects) {
                    return $subjects->status ? 1 : 0;
                })
                ->addColumn('action', function ($subjects) {
                    return '';
                })
                ->make(true);
        }

        return view('academics.subjects.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcourses  = SubCourse::where('status', 1)->get();
        return view('academics.subjects.create', compact('subcourses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'subcourse_id' => 'required|exists:sub_courses,id',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Prepare data
            $data = [
                'name' => $request->name,
                'code' => $request->code,
                'subcourse_id' => $request->subcourse_id,
                'status' => $request->has('status') ? $request->status : 1,
            ];

            // Create subject
            $subject = Subject::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Subject added successfully!',
                'data' => $subject
            ]);
        } catch (Exception $e) {
            // Catch unexpected errors
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($subjectID)
    {
        $subject  = Subject::findOrFail($subjectID);
        $subcourses  = SubCourse::where('status', 1)->get();
        return view('academics.subjects.edit', compact('subject', 'subcourses'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified subject in storage.
     */
    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the subject or fail
        $subject = Subject::findOrFail($id);

        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:50',
            'subcourse_id' => 'required|exists:sub_courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Update subject data
            $subject->name = $request->name;
            $subject->code = $request->code;
            $subject->subcourse_id = $request->subcourse_id;

            $subject->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Subject updated successfully!',
                'data' => $subject
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($subjectId)
    { {
            try {
                $subject = Subject::destroy($subjectId);
                return ['status' => 'success', 'message' => 'Subject deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            if ($subject) {
                $subject->status = $subject->status == 1 ? 0 : 1;
                $subject->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $subject->name . ' status updated successfully!',
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
}
