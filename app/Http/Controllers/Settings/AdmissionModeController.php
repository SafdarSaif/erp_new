<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\AdmissionMode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\CourseType;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class AdmissionModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $courseTypes = AdmissionMode::orderBy('id', 'desc')->get();

            return DataTables::of($courseTypes)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.admissionmode.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Settings.admissionmode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:admission_modes,name',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            // Create Admission Mode
            $admissionMode = AdmissionMode::create([
                'name' => $request->name,
                'status' => 1, // default active
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Admission Mode created successfully.',
                'data' => $admissionMode,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AdmissionMode $admissionMode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($admissionModeID)
    {
        $admissionMode = AdmissionMode::findOrFail($admissionModeID);
        return view('Settings.admissionmode.edit', compact('admissionMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $admissionModeID)
    {
        try {
            // Find the Admission Mode
            $admissionMode = AdmissionMode::findOrFail($admissionModeID);

            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:admission_modes,name,' . $admissionMode->id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            // Update Admission Mode
            $admissionMode->update([
                'name' => $request->name,
                'status' => $request->has('status') ? $request->status : $admissionMode->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Admission Mode updated successfully.',
                'data' => $admissionMode,
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
    public function destroy($admissionModeID)
    { {
            try {
                $admissionmode = AdmissionMode::destroy($admissionModeID);
                return ['status' => 'success', 'message' => 'Course Type deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $admissionmode = AdmissionMode::findOrFail($id);
            if ($admissionmode) {
                $admissionmode->status = $admissionmode->status == 1 ? 0 : 1;
                $admissionmode->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $admissionmode->name . ' status updated successfully!',
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
