<?php

namespace App\Http\Controllers;

use App\Models\Academics\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Academics\University;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $departments = Department::with('university')->orderBy('id', 'desc')->get();

            return DataTables::of($departments)
                ->addIndexColumn()
                ->addColumn('university', function ($department) {
                    return $department->university->name ?? '-';
                })
                ->editColumn('status', function ($department) {
                    return $department->status ? 1 : 0;
                })
                ->addColumn('action', function ($department) {
                    return '';
                })
                ->make(true);
        }

        return view('academics.department.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universities = University::where('status', 1)->get();
        return view('academics.department.create', compact('universities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'university_id' => 'required|exists:universities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $department = Department::create([
            'name' => $request->name,
            'university_id' => $request->university_id,
            'status' => $request->input('status', 1),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Department added successfully!',
            'data' => $department
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $universities = University::where('status', 1)->get();
        return view('academics.department.edit', compact('department', 'universities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'university_id' => 'required|exists:universities,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $department = Department::findOrFail($id);

        $department->update([
            'name' => $request->name,
            'university_id' => $request->university_id,
            'status' => $request->input('status', 1),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Department updated successfully!',
            'data' => $department
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($departmentId)
    { {
            try {
                $department = Department::destroy($departmentId);
                return ['status' => 'success', 'message' => 'department deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $department = Department::findOrFail($id);
            if ($department) {
                $department->status = $department->status == 1 ? 0 : 1;
                $department->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $department->name . ' status updated successfully!',
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
