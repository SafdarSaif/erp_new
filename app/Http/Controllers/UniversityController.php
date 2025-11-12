<?php

namespace App\Http\Controllers;

use App\Models\Academics\University;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $universities = University::orderBy('id', 'desc')->get();

            return DataTables::of($universities)
                ->addIndexColumn()
                ->addColumn('logo', function ($university) {
                    return $university->logo
                        ? '<img src="' . asset($university->logo) . '" width="30" height="30" class="rounded-circle">'
                        : '-';
                })
                ->editColumn('status', function ($university) {
                    return $university->status ? 1 : 0;
                })
                ->addColumn('action', function ($university) {
                    return '';
                })
                ->rawColumns(['logo'])
                ->make(true);
        }

        return view('academics.university.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academics.university.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'prefix' => 'nullable|string|max:10',
            'length' => 'nullable|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Handle logo upload
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->move(public_path('uploads/universities'), $filename);
                $logoPath = 'uploads/universities/' . $filename;
            }

            // Create new university
            $university = University::create([
                'name' => $request->name,
                'prefix' => $request->prefix,
                'length' => $request->length,
                'logo' => $logoPath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'University added successfully!',
                'data' => $university
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function edit($universityId)
    {
        $university = University::findOrFail($universityId);




        return view('academics.university.edit', compact('university'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(University $university)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified university in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'prefix' => 'nullable|string|max:10',
            'length' => 'nullable|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $university = University::findOrFail($id);

            // Handle logo upload
            $logoPath = $university->logo; // keep old if not replaced
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($university->logo && file_exists(public_path($university->logo))) {
                    unlink(public_path($university->logo));
                }

                $file = $request->file('logo');
                $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->move(public_path('uploads/universities'), $filename);
                $logoPath = 'uploads/universities/' . $filename;
            }

            // Update record
            $university->update([
                'name' => $request->name,
                'prefix' => $request->prefix,
                'length' => $request->length,
                'logo' => $logoPath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'University updated successfully!',
                'data' => $university
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($universityId)
    { {
            try {
                $university = University::destroy($universityId);
                return ['status' => 'success', 'message' => 'university deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $university = University::findOrFail($id);
            if ($university) {
                $university->status = $university->status == 1 ? 0 : 1;
                $university->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $university->name . ' status updated successfully!',
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
