<?php

namespace App\Http\Controllers;

use App\Models\RoleReporting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create(Request $request)
    // {
    //     // Get all roles
    //     $roles = Role::orderBy('id')->get();

    //     // Get role_id safely from request (query string)
    //     $currentRoleId = $request->query('role_id', null); // null if not passed

    //     return view('user.rolesReport.create', compact('roles', 'currentRoleId'));
    // }

    public function create(Request $request)
{
    $roles = Role::orderBy('id')->get();

    $currentRoleId = $request->query('role_id', null);

    // Fetch existing hierarchy for edit
    $existing = RoleReporting::where('role_id', $currentRoleId)->first();

    return view('user.rolesReport.create', compact('roles', 'currentRoleId', 'existing'));
}




    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $request->validate([
        'role_id' => 'required|integer',
        'parent_id' => 'nullable|integer|different:role_id',
    ]);

    try {
        RoleReporting::updateOrCreate(
            ['role_id' => $request->role_id],
            ['parent_id' => $request->parent_id]
        );

        return response()->json([
            'status' => true,
            'message' => 'Hierarchy saved successfully.',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(RoleReporting $roleReporting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoleReporting $roleReporting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleReporting $roleReporting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleReporting $roleReporting)
    {
        //
    }
}
