<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;


class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = Status::orderBy('id', 'desc')->get();
            return DataTables::of($status)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Settings.status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:statuses,name',
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
            // Create Status
            $status = new Status();
            $status->name = $request->name;
            $status->status = $request->has('status') ? $request->status : 1;
            $status->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Status created successfully',
                'data' => $status
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
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($statusID)
    {
        $status = Status::findOrFail($statusID);
        return view('Settings.status.edit', compact('status'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $statusID)
    {
        try {
            $status = Status::findOrFail($statusID);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:statuses,name,' . $status->id,
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $status->update([
                'name' => $request->name,
                'status' => $request->has('status') ? $request->status : $status->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully.',
                'data' => $status,
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
    public function destroy($statusID)
    {
        try {
            $status = Status::destroy($statusID);
            return ['status' => 'success', 'message' => 'Status deleted successfully!'];
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    /**
     * Toggle status active/inactive.
     */
    public function status($id)
    {
        try {
            $status = Status::findOrFail($id);
            if ($status) {
                $status->status = $status->status == 1 ? 0 : 1;
                $status->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $status->name . ' status updated successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Status not found',
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
