<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;


class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $language = Language::orderBy('id', 'desc')->get();

            return DataTables::of($language)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.language.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Settings.language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:languages,name',
            'short_name' => 'required|string|max:50|unique:languages,short_name',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $language = Language::create([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'status' => $request->status ?? 1,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Language added successfully!',
                'data' => $language
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
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($languageID)
    {

        $language = Language::findOrFail($languageID);
        return view('Settings.language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $languageID)
    {
        $language = Language::findOrFail($languageID);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:languages,name,' . $language->id,
            'short_name' => 'required|string|max:50|unique:languages,short_name,' . $language->id,
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $language->update([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'status' => $request->status ?? $language->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Language updated successfully!',
                'data' => $language
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
    public function destroy($languageID)
    { {
            try {
                $language = Language::destroy($languageID);
                return ['status' => 'success', 'message' => 'Language deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $language = Language::findOrFail($id);
            if ($language) {
                $language->status = $language->status == 1 ? 0 : 1;
                $language->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $language->name . ' status updated successfully!',
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
