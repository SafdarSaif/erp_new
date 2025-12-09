<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;


use App\Models\Settings\NotificationHeader;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class NotificationHeaderController extends Controller

{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $notificationHeader = NotificationHeader::orderBy('id', 'desc')->get();
            return DataTables::of($notificationHeader)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.notificationheader.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('Settings.notificationheader.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    // Validation rules
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|unique:notification_headers,name',
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
        // Create Notification Header
        $notificationHeader = new NotificationHeader();
        $notificationHeader->name = $request->name;
        $notificationHeader->status = $request->has('status') ? $request->status : 1;
        $notificationHeader->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification Header created successfully',
            'data' => $notificationHeader
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 0,
            'message' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(NotificationHeader $notificationHeader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $notificationHeader = NotificationHeader::findOrFail($id);
        return view('Settings.notificationheader.edit', compact('notificationHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Fetch the Notification Header
    $notificationHeader = NotificationHeader::findOrFail($id);

    // Validation rules
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|unique:notification_headers,name,' . $notificationHeader->id,
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
        // Update Notification Header
        $notificationHeader->name = $request->name;
        $notificationHeader->status = $request->has('status') ? $request->status : 1;
        $notificationHeader->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification Header updated successfully',
            'data' => $notificationHeader
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 0,
            'message' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $notificationHeader = NotificationHeader::destroy($id);
            return ['status' => 'success', 'message' => 'NotificationHeader deleted successfully!'];
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
            $notificationHeader = NotificationHeader::findOrFail($id);
            if ($notificationHeader) {
                $notificationHeader->status = $notificationHeader->status == 1 ? 0 : 1;
                $notificationHeader->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $notificationHeader->name . ' status updated successfully!',
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
