<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (Auth::check() && Auth::user()->hasPermissionTo('view users')) {
            if ($request->ajax()) {

                $data = User::orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('role', function ($data) {
                        $role = $data->getRoleNames();
                        return $role;
                    })
                    ->editColumn('created_at', function ($data) {
                        return Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d-m-Y h:i A');
                    })
                    ->make(true);
            }
            return view('user.index');
        } else {
            return response()->view('errors.403', [], 403);
        }
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('create users')) {
            $roles = \Spatie\Permission\Models\Role::all();
            return view('user.create', ['roles' => $roles]);
        } else {
            return response()->view('errors.403', [], 403);
        }
    }

    public function store(UserRequest $request)
    {
        // dd($request->all());

        if (!Auth::check() || !Auth::user()->hasPermissionTo('create users')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access!',
            ], 403);
        }

        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);

            // Assign Role
            if ($request->role_id) {
                $role = Role::find($request->role_id);
                if ($role) {
                    $user->assignRole([$role->id]);
                }
            }

            // Handle Avatar Upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $this->uploadImage($request->file('avatar'), 'uploads/avatars');
                $user->update([
                    'avatar' => $avatarPath,
                    'profile_photo_path' => $avatarPath
                ]);
            }




            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully!',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }









    //   public function edit($userId)
    //   {
    //     if (Auth::check() && Auth::user()->hasPermissionTo('edit users')) {
    //       $user = User::find($userId);
    //       $roles = \Spatie\Permission\Models\Role::all();
    //       return view('user.edit', ['user' => $user, 'roles' => $roles]);
    //     } else {
    //       return response()->view('errors.403', [], 403);
    //     }
    //   }


    public function edit($userId)
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('edit users')) {
            $user = User::findOrFail($userId);
            $roles = Role::all();

            // Get all assigned role IDs for this user
            $userRoleIds = $user->roles->pluck('id')->toArray();

            return view('user.edit', compact('user', 'roles', 'userRoleIds'));
        } else {
            return response()->view('errors.403', [], 403);
        }
    }



    public function update(Request $request, $userId)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'mobile' => 'required|digits:10|unique:users,mobile,' . $userId,
            'password' => 'nullable|min:6',
            'role_id' => 'nullable|exists:roles,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validate `avatar`
        ]);

        try {
            // Find user record
            $user = User::findOrFail($userId);

            // Handle avatar upload (stored as `profile_photo_path`)
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->profile_photo_path && File::exists(public_path($user->profile_photo_path))) {
                    File::delete(public_path($user->profile_photo_path));
                }

                // Upload new avatar
                $avatarPath = $this->uploadImage($request->file('avatar'), 'uploads/avatars');
                $user->profile_photo_path = $avatarPath;
            }

            // Update user details
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'profile_photo_path' => $user->profile_photo_path, // Store as `profile_photo_path`
            ]);

            // Update password if provided
            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Assign new role if changed
            if ($request->role_id) {
                $role = Role::find($request->role_id);
                if ($role) {
                    $user->syncRoles([$role->id]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully!',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function destroy($userId)
    // { {
    //         try {
    //             $user = User::destroy($userId);
    //             return ['status' => 'success', 'message' => 'User  deleted successfully!'];
    //         } catch (\Throwable $e) {
    //             return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    //         }
    //     }
    // }

    public function destroy($id)
    {
        try {
            $data = User::findOrFail($id);
            if ($data) {
                User::find($id)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => $data->name . ' Deleted successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not found',
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
