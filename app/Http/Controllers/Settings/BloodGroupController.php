<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\BloodGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class BloodGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bloodgroup = BloodGroup::orderBy('id', 'desc')->get();

            return DataTables::of($bloodgroup)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.bloodgroup.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Settings.bloodgroup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:10|unique:blood_groups,name', // e.g., A+, O-
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Create blood group
            $bloodGroup = BloodGroup::create([
                'name' => strtoupper($request->name), // Optional: store in uppercase
                'status' => $request->status ?? 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Blood group added successfully!',
                'data' => $bloodGroup
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
    public function show(BloodGroup $bloodGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($bloodGroupID)
    {
        $bloodGroup = BloodGroup::findOrFail($bloodGroupID);
        return view('Settings.bloodgroup.edit', compact('bloodGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $bloodGroup = BloodGroup::findOrFail($id);

    // Validate input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:10|unique:blood_groups,name,' . $bloodGroup->id,
        'status' => 'nullable|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first()
        ], 422);
    }

    try {
        $bloodGroup->update([
            'name' => strtoupper($request->name),
            'status' => $request->status ?? $bloodGroup->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Blood group updated successfully!',
            'data' => $bloodGroup
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
    public function destroy($bloodGroupID)
    { {
            try {
                $bloodGroup = BloodGroup::destroy($bloodGroupID);
                return ['status' => 'success', 'message' => 'Blood Group deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $bloodGroup = BloodGroup::findOrFail($id);
            if ($bloodGroup) {
                $bloodGroup->status = $bloodGroup->status == 1 ? 0 : 1;
                $bloodGroup->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $bloodGroup->name . ' status updated successfully!',
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
