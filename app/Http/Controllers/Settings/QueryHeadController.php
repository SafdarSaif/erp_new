<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\QueryHead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;


class QueryHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $queryHeads = QueryHead::orderBy('id', 'desc')->get();
            return DataTables::of($queryHeads)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.queryhead.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Settings.queryhead.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:query_heads,name',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $queryHead = new QueryHead();
            $queryHead->name = $request->name;
            $queryHead->status = $request->has('status') ? $request->status : 1;
            $queryHead->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Query Head created successfully.',
                'data' => $queryHead
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $queryhead = QueryHead::findOrFail($id);
        return view('Settings.queryhead.edit', compact('queryhead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $queryHead = QueryHead::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:query_heads,name,' . $queryHead->id,
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            // ✅ Using save() instead of update()
            $queryHead->name = $request->name;
            $queryHead->status = $request->has('status') ? $request->status : $queryHead->status;
            $queryHead->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Query Head updated successfully.',
                'data' => $queryHead,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            QueryHead::destroy($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Query Head deleted successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle status active/inactive.
     */
    public function status($id)
    {
        try {
            $queryHead = QueryHead::findOrFail($id);
            $queryHead->status = $queryHead->status == 1 ? 0 : 1;
            $queryHead->save();

            return response()->json([
                'status' => 'success',
                'message' => $queryHead->name . ' status updated successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
