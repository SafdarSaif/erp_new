<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\Documents;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Academics\University;
use Illuminate\Support\Facades\Validator;
use Exception;

class DocumentsController extends Controller
{
    // public function index()
    // {
    //     if (request()->ajax()) {
    //         $bloodgroup = Documents::orderBy('id', 'desc')->get();

    //         return DataTables::of($bloodgroup)
    //             ->addIndexColumn()
    //             ->editColumn('status', fn($row) => $row->status ? 1 : 0)
    //             ->addColumn('action', fn($row) => '')
    //             ->make(true);
    //     }

    //     return view('Settings.documents.index');
    // }



    public function index()
    {
        if (request()->ajax()) {

            $documents = Documents::orderBy('id', 'desc')->get();

            return DataTables::of($documents)
                ->addIndexColumn()

                // NAME
                ->addColumn('name', fn($row) => $row->name)

                // ACCEPTABLE TYPES (convert array → string)
                ->addColumn('acceptable_type', function ($row) {
                    if (!$row->acceptable_type) return '-';
                    return implode(', ', $row->acceptable_type);
                })

                // MAX SIZE
                ->addColumn('max_size', fn($row) => $row->max_size ? $row->max_size . ' MB' : '-')

                // REQUIRED (Yes/No)
                ->addColumn('is_required', fn($row) => $row->is_required ? 'Yes' : 'No')

                // UNIVERSITY NAMES
                ->addColumn('university', function ($row) {
                    if (!$row->university_id) return '-';

                    $names = University::whereIn('id', $row->university_id)
                        ->pluck('name')->toArray();

                    return implode(', ', $names);
                })

                // STATUS
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)

                // ACTION BUTTONS
                ->addColumn('action', fn($row) => '')

                ->rawColumns(['acceptable_type', 'university'])
                ->make(true);
        }

        return view('Settings.documents.index');
    }


    public function create()
    {
        $universities = University::where('status', 1)->get();
        return view('Settings.documents.create', compact('universities'));
    }







    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',

    //         'acceptable_type'      => 'required|array',        // array
    //         'acceptable_type.*'    => 'string|max:10',         // each item string

    //         'max_size'    => 'nullable|integer|min:1|max:50',
    //         'is_required' => 'nullable|boolean',

    //         'university_id'      => 'required|array',          // array
    //         'university_id.*'    => 'exists:universities,id',  // each ID exists
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     // prepare data
    //     $data = [
    //         'name'            => $request->name,
    //         'acceptable_type' => $request->acceptable_type,    // JSON via cast
    //         'max_size'        => $request->max_size,
    //         'is_required'     => $request->input('is_required', 0),
    //         'university_id'   => $request->university_id,      // JSON via cast
    //         'status'          => 1,
    //     ];

    //     // create one record
    //     $document = Documents::create($data);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Document added successfully!',
    //         'data'    => $document
    //     ]);
    // }


    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',

        'acceptable_type'   => 'required|array',        // array
        'acceptable_type.*' => 'string|max:10',         // each item string

        'max_size'    => 'nullable|integer|min:1|max:50',
        'is_required' => 'nullable|boolean',
        'is_multiple' => 'nullable|boolean',            // new field

        'university_id'      => 'required|array',          // array
        'university_id.*'    => 'exists:universities,id',  // each ID exists
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first()
        ], 422);
    }

    // prepare data
    $data = [
        'name'            => $request->name,
        'acceptable_type' => $request->acceptable_type,       // JSON cast in model
        'max_size'        => $request->max_size,
        'is_required'     => $request->input('is_required', 0),
        'is_multiple'     => $request->input('is_multiple', 0), // default 0 if unchecked
        'university_id'   => $request->university_id,          // JSON cast in model
        'status'          => 1,
    ];

    // create record
    $document = Documents::create($data);

    return response()->json([
        'status' => 'success',
        'message' => 'Document added successfully!',
        'data'    => $document
    ]);
}





    // EDIT DOCUMENT
    public function edit($id)
    {
        $document = Documents::findOrFail($id);
        $universities = University::where('status', 1)->get();

        return view('Settings.documents.edit', compact('document', 'universities'));
    }



    // UPDATE DOCUMENT
    // public function update(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',

    //         'acceptable_type'      => 'required|array',
    //         'acceptable_type.*'    => 'string|max:10',

    //         'max_size'    => 'nullable|integer|min:1|max:50',
    //         'is_required' => 'nullable|boolean',

    //         'university_id'      => 'required|array',
    //         'university_id.*'    => 'exists:universities,id',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     $document = Documents::findOrFail($id);

    //     $document->update([
    //         'name'            => $request->name,
    //         'acceptable_type' => $request->acceptable_type,
    //         'max_size'        => $request->max_size,
    //         'is_required'     => $request->input('is_required', 0),
    //         'university_id'   => $request->university_id,
    //     ]);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Document updated successfully!'
    //     ]);
    // }


    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',

        'acceptable_type'   => 'required|array',
        'acceptable_type.*' => 'string|max:10',

        'max_size'    => 'nullable|integer|min:1|max:50',
        'is_required' => 'nullable|boolean',

        'is_multiple' => 'nullable|boolean',   // <-- added

        'university_id'      => 'required|array',
        'university_id.*'    => 'exists:universities,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first()
        ], 422);
    }

    $document = Documents::findOrFail($id);

    // Handle checkbox (if unchecked it does not come in request)
    $isMultiple = $request->has('is_multiple') ? 1 : 0;

    $document->update([
        'name'            => $request->name,
        'acceptable_type' => $request->acceptable_type,
        'max_size'        => $request->max_size,
        'is_required'     => $request->input('is_required', 0),
        'university_id'   => $request->university_id,
        'is_multiple'     => $isMultiple,   // <-- checkbox stored correctly
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Document updated successfully!'
    ]);
}



    public function status($id)
    {
        try {
            $documents = Documents::findOrFail($id);
            if ($documents) {
                $documents->status = $documents->status == 1 ? 0 : 1;
                $documents->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $documents->name . ' status updated successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Documents not found',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }



    public function destroy($id)
    {
        try {
            $document = Documents::findOrFail($id);
            $document->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Document deleted successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete document.'
            ], 500);
        }
    }




}
