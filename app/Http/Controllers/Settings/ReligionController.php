<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\Religion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class ReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $religion = Religion::orderBy('id', 'desc')->get();

            return DataTables::of($religion)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.religion.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Settings.religion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:religions,name',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $religion = Religion::create([
                'name' => ucfirst($request->name),
                'status' => $request->status ?? 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Religion added successfully!',
                'data' => $religion
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
    public function show(Religion $religion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
    {
        $religion = Religion::findOrFail($id);
        return view('Settings.religion.edit', compact('religion'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $religionID)
    {
        try {
            $religion = Religion::findOrFail($religionID);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100|unique:religions,name,' . $religion->id,
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $religion->update([
                'name' => ucfirst($request->name),
                'status' => $request->has('status') ? $request->status : $religion->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Religion updated successfully!',
                'data' => $religion,
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
     public function destroy($religionID)
    { {
            try {
                $religion = Religion::destroy($religionID);
                return ['status' => 'success', 'message' => 'Religion deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $religion = Religion::findOrFail($id);
            if ($religion) {
                $religion->status = $religion->status == 1 ? 0 : 1;
                $religion->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $religion->name . ' status updated successfully!',
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
