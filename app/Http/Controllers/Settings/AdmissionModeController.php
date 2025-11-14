<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\AdmissionMode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Auth;

class AdmissionModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                Log::info('AdmissionModeController@index - Fetching Admission Modes (AJAX)', [
                    'user_id' => auth()->id(),
                ]);

                $admissionModes = AdmissionMode::orderBy('id', 'desc')->get();

                return DataTables::of($admissionModes)
                    ->addIndexColumn()
                    ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                    ->addColumn('action', fn($row) => '')
                    ->make(true);
            }

            Log::info('AdmissionModeController@index - Loading view', [
                'user_id' => auth()->id(),
            ]);
            return view('Settings.admissionmode.index');
        } catch (Exception $e) {
            Log::error('AdmissionModeController@index - Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->view('errors.500', [], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            Log::info('AdmissionModeController@create - Opening create view', [
                'user_id' => auth()->id(),
            ]);
            return view('Settings.admissionmode.create');
        } catch (Exception $e) {
            Log::error('AdmissionModeController@create - Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->view('errors.500', [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('AdmissionModeController@store - Request received', [
                'user_id' => auth()->id(),
                'data' => $request->all(),
            ]);

            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:admission_modes,name',
            ]);

            if ($validator->fails()) {
                Log::warning('AdmissionModeController@store - Validation failed', [
                    'errors' => $validator->errors()->toArray(),
                ]);

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

            Log::info('AdmissionModeController@store - Admission Mode created successfully', [
                'id' => $admissionMode->id,
                'name' => $admissionMode->name,
                'created_by' => auth()->id(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Admission Mode created successfully.',
                'data' => $admissionMode,
            ]);
        } catch (Exception $e) {
            Log::error('AdmissionModeController@store - Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($admissionModeID)
    {
        try {
            Log::info('AdmissionModeController@edit - Fetching Admission Mode for edit', [
                'id' => $admissionModeID,
                'user_id' => auth()->id(),
            ]);

            $admissionMode = AdmissionMode::findOrFail($admissionModeID);
            return view('Settings.admissionmode.edit', compact('admissionMode'));
        } catch (Exception $e) {
            Log::error('AdmissionModeController@edit - Exception', [
                'id' => $admissionModeID,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error loading admission mode: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $admissionModeID)
    {
        try {
            Log::info('AdmissionModeController@update - Request received', [
                'id' => $admissionModeID,
                'user_id' => auth()->id(),
                'data' => $request->all(),
            ]);

            $admissionMode = AdmissionMode::findOrFail($admissionModeID);

            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:admission_modes,name,' . $admissionMode->id,
            ]);

            if ($validator->fails()) {
                Log::warning('AdmissionModeController@update - Validation failed', [
                    'errors' => $validator->errors()->toArray(),
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            // Update
            $admissionMode->update([
                'name' => $request->name,
                'status' => $request->has('status') ? $request->status : $admissionMode->status,
            ]);

            Log::info('AdmissionModeController@update - Updated successfully', [
                'id' => $admissionMode->id,
                'name' => $admissionMode->name,
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Admission Mode updated successfully.',
                'data' => $admissionMode,
            ]);
        } catch (Exception $e) {
            Log::error('AdmissionModeController@update - Exception', [
                'id' => $admissionModeID,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);

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
    {
        try {
            Log::info('AdmissionModeController@destroy - Request received', [
                'id' => $admissionModeID,
                'user_id' => auth()->id(),
            ]);

            $deleted = AdmissionMode::destroy($admissionModeID);

            if ($deleted) {
                Log::info('AdmissionModeController@destroy - Deleted successfully', [
                    'id' => $admissionModeID,
                    'deleted_by' => auth()->id(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Admission Mode deleted successfully!',
                ]);
            } else {
                Log::warning('AdmissionModeController@destroy - Not found', [
                    'id' => $admissionModeID,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Admission Mode not found.',
                ], 404);
            }
        } catch (Exception $e) {
            Log::error('AdmissionModeController@destroy - Exception', [
                'id' => $admissionModeID,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting Admission Mode: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle the status of the Admission Mode.
     */
    public function status($id)
    {
        try {
            Log::info('AdmissionModeController@status - Status toggle requested', [
                'id' => $id,
                'user_id' => auth()->id(),
            ]);

            $admissionmode = AdmissionMode::findOrFail($id);

            $admissionmode->status = $admissionmode->status == 1 ? 0 : 1;
            $admissionmode->save();

            Log::info('AdmissionModeController@status - Status updated', [
                'id' => $id,
                'new_status' => $admissionmode->status,
                'updated_by' => auth()->id(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => $admissionmode->name . ' status updated successfully!',
            ]);
        } catch (Exception $e) {
            Log::error('AdmissionModeController@status - Exception', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error updating status: ' . $e->getMessage(),
            ]);
        }
    }
}
