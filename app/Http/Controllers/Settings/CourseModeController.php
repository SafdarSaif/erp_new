<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\CourseMode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;


class CourseModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $courseModes = CourseMode::orderBy('id', 'desc')->get();
            return DataTables::of($courseModes)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.coursemode.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('Settings.coursemode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    // Validation rules
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|unique:course_modes,name',
        'status' => 'nullable|boolean',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => 0,
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        // Create Course Mode
        $courseMode = new CourseMode();
        $courseMode->name = $request->name;
        $courseMode->status = $request->has('status') ? $request->status : 1; // Default active
        $courseMode->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Course Mode created successfully',
            'data' => $courseMode
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 0,
            'message' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(CourseMode $courseMode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($courseModeID)
    {
        $courseMode = CourseMode::findOrFail($courseModeID);
        return view('Settings.coursemode.edit', compact('courseMode'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id)
    {
        try {
            $courseMode = CourseMode::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:course_modes,name,' . $courseMode->id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $courseMode->update([
                'name' => $request->name,
                'status' => $request->has('status') ? $request->status : $courseMode->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Course Mode updated successfully.',
                'data' => $courseMode,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($coursemodeID)
    { {
            try {
                $courseMode = CourseMode::destroy($coursemodeID);
                return ['status' => 'success', 'message' => 'Course Mode  deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $courseMode = CourseMode::findOrFail($id);
            if ($courseMode) {
                $courseMode->status = $courseMode->status == 1 ? 0 : 1;
                $courseMode->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $courseMode->name . ' status updated successfully!',
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
