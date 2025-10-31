<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return view('menu.index');
    // }




    public function index(Request $request)
    {
        if ($request->ajax()) {
            $menus = Menu::with('parent')->orderBy('id', 'desc')->get();

            return DataTables::of($menus)
                ->addIndexColumn()
                ->editColumn('parent', function ($menu) {
                    return $menu->parent ? $menu->parent->name : '-';
                })
                ->addColumn('icon', function ($menu) {
                    return $menu->icon
                        ? '<img src="' . asset($menu->icon) . '" width="30" height="30" class="rounded-circle">'
                        : '-';
                })
                ->editColumn('is_active', function ($menu) {
                    return $menu->is_active ? 1 : 0;
                })
                ->addColumn('action', function ($menu) {
                    return '';
                })
                ->rawColumns(['icon'])
                ->make(true);
        }

        return view('menu.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    //  public function create()
    // {

    //     return view('menu.create');
    // }

    public function create()
    {

        $parents = Menu::where('is_active', 1)->get();
        $permission = Permission::pluck('id', 'name');
        // dd($permission);

        return view('menu.create', compact('parents', 'permission'));
    }


    /**
     * Store a newly created resource in storage.
     */


    // public function store(Request $request)
    // {
    //     // Validate request
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'parent_id' => 'nullable|exists:menus,id',
    //         'url' => 'nullable|string|max:255',
    //         'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
    //         'position' => 'required|integer',
    //         'permission' => 'nullable|string|max:255',
    //         // 'is_searchable' => 'nullable|integer|in:0,1',
    //         // 'is_parent' => 'nullable|integer|in:0,1',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     try {
    //         // Prepare data array
    //         $data = [
    //             'name' => $request->name,
    //             'parent_id' => $request->parent_id,
    //             'url' => $request->url,
    //             'position' => $request->position,
    //             'permission' => $request->permission,
    //             // 'is_searchable' => $request->has('is_searchable') ? 1 : 0,
    //             // 'is_parent' => $request->has('is_parent') ? 1 : 0,
    //         ];

    //         // Handle icon upload
    //         if ($request->hasFile('icon')) {
    //             $file = $request->file('icon');
    //             $filename = time() . '_' . $file->getClientOriginalName();
    //             $file->move(public_path('uploads/icons'), $filename);
    //             $data['icon'] = 'uploads/icons/' . $filename;
    //         }

    //         // Create or update
    //         if ($request->id) {
    //             $menu = Menu::findOrFail($request->id);
    //             $menu->update($data);
    //         } else {
    //             $menu = Menu::create($data);
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => $request->id ? 'Menu updated successfully!' : 'Menu added successfully!',
    //             'data' => $menu
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Something went wrong! ' . $e->getMessage()
    //         ], 500);
    //     }
    // }



    // public function store(Request $request)
    // {
    //     // Validate request
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'parent_id' => 'nullable|exists:menus,id',
    //         'url' => 'nullable|string|max:255',
    //         'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
    //         'position' => 'required|integer',
    //         'permission' => 'nullable|string|max:255',
    //         'is_active' => 'nullable|boolean',
    //         'is_searchable' => 'nullable|boolean',
    //         'is_parent' => 'nullable|boolean',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     try {
    //         // Prepare data
    //         $data = [
    //             'name' => $request->name,
    //             'parent_id' => $request->parent_id,
    //             'url' => $request->url,
    //             'position' => $request->position,
    //             'permission' => $request->permission,
    //             'is_active' => $request->has('is_active') ? 1 : 0,
    //             'is_searchable' => $request->has('is_searchable') ? 1 : 0,
    //             'is_parent' => $request->has('is_parent') ? 1 : 0,
    //         ];

    //         // Handle icon upload
    //         if ($request->hasFile('icon')) {
    //             $file = $request->file('icon');
    //             $filename = time() . '_' . $file->getClientOriginalName();
    //             $file->move(public_path('uploads/icons'), $filename);
    //             $data['icon'] = 'uploads/icons/' . $filename;
    //         }

    //         // Create or update
    //         if ($request->id) {
    //             $menu = Menu::findOrFail($request->id);
    //             $menu->update($data);
    //         } else {
    //             $menu = Menu::create($data);
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => $request->id ? 'Menu updated successfully!' : 'Menu added successfully!',
    //             'data' => $menu
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Something went wrong! ' . $e->getMessage()
    //         ], 500);
    //     }
    // }


    public function store(Request $request)

    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'position' => 'required|integer',
            'permission' => 'nullable|string|max:255',
            'is_active' => 'nullable|string',
            'is_searchable' => 'nullable|string',
            'is_parent' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Handle icon upload
            $iconPath = null;
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/icons'), $filename);
                $iconPath = 'uploads/icons/' . $filename;
            }

            // Create a new menu
            $menu = Menu::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'url' => $request->url,
                'position' => $request->position,
                'permission' => $request->permission,
                'is_active' => $request->input('is_active', '1'),
                'is_searchable' => $request->input('is_searchable', '0'),
                'is_parent' => $request->input('is_parent', '0'),
                'icon' => $iconPath,
                'added_by' => Auth::user()->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Menu added successfully!',
                'data' => $menu
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
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $parents = Menu::where('is_active', 1)->get();
        $permission = Permission::pluck('id', 'name');



        return view('menu.edit', compact('menu', 'parents', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Menu $menu)
    // {
    //     //
    // }


    public function update(Request $request, $id)
{
    // Validate request
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:2|max:255',
        'parent_id' => 'nullable|exists:menus,id',
        'url' => 'nullable|string|max:255',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        'position' => 'required|integer',
        'permission' => 'nullable|string|max:255',
        'is_active' => 'nullable|string',
        'is_searchable' => 'nullable|string',
        'is_parent' => 'nullable|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first()
        ], 422);
    }

    try {
        $menu = Menu::findOrFail($id);

        // Handle icon upload
        $iconPath = $menu->icon; // keep old if not replaced
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/icons'), $filename);
            $iconPath = 'uploads/icons/' . $filename;
        }

        // Update record
        $menu->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'url' => $request->url,
            'position' => $request->position,
            'permission' => $request->permission,
            'is_active' => $request->input('is_active', '1'),
            'is_searchable' => $request->input('is_searchable', '0'),
            'is_parent' => $request->input('is_parent', '0'),
            'icon' => $iconPath,
            'updated_by' => Auth::user()->id, // if you have this column
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Menu updated successfully!',
            'data' => $menu
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
     public function destroy($menuId)
    { {
            try {
                $menu = Menu::destroy($menuId);
                return ['status' => 'success', 'message' => 'Menu deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
      public function status($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            if ($menu) {
                $menu->is_active = $menu->is_active == 1 ? 0 : 1;
                $menu->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $menu->name . ' status updated successfully!',
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

   public static function getMenuHierarchy($menus, $parentId = null)
    {
        $result = [];

        foreach ($menus as $menu) {
            print_r($menu->toArray());
            echo "\n";
            // Use loose comparison for parent_id null/0 issues
            if (($parentId === null && $menu['parent_id'] === null) || $menu['parent_id'] == $parentId) {
                // Recursively find children
                $children = self::getMenuHierarchy($menus, $menu['id']);

                if (!empty($children)) {
                    $menu['children'] = $children;
                }

                $result[] = $menu; // Add menu with children (if any)
            }
        }
        dd();
        return $result;
    }
}
