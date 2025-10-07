<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\CourseType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class CourseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $courseTypes = CourseType::orderBy('id', 'desc')->get();

            return DataTables::of($courseTypes)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.coursetype.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('Settings.coursetype.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:course_types,name',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        try {
            $courseType = CourseType::create([
                'name' => $request->name,
                'status' => $request->status ?? 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Course Type added successfully!',
                'data' => $courseType
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseType $courseType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($courseTypeID)
    {
        $courseType = CourseType::findOrFail($courseTypeID);
        return view('Settings.coursetype.edit', compact('courseType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $courseType = CourseType::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:course_types,name,' . $id,
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        try {
            $courseType->update([
                'name' => $request->name,
                'status' => $request->status ?? 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Course Type updated successfully!',
                'data' => $courseType
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
    public function destroy($courseTypeID)
    { {
            try {
                $coursetype = CourseType::destroy($courseTypeID);
                return ['status' => 'success', 'message' => 'Course Type deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $coursetype = CourseType::findOrFail($id);
            if ($coursetype) {
                $coursetype->status = $coursetype->status == 1 ? 0 : 1;
                $coursetype->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $coursetype->name . ' status updated successfully!',
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
