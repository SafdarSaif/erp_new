<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $menus = Theme::orderBy('id', 'desc')->get();

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

        return view('theme.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('theme.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|min:2|max:255',
            'tag_line'        => 'nullable|string|max:255',
            'main_color'      => 'nullable|string|max:7',
            'top_color'       => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'favicon'         => 'nullable|image|mimes:jpeg,png,jpg,svg,ico|max:1024',
            'custom_colors'   => 'nullable|string',
            'is_active'       => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Handle logo upload
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/theme'), $filename);
                $logoPath = 'uploads/theme/' . $filename;
            }

            // Handle favicon upload
            $faviconPath = null;
            if ($request->hasFile('favicon')) {
                $file = $request->file('favicon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/theme'), $filename);
                $faviconPath = 'uploads/theme/' . $filename;
            }

            // Create or update theme
            $theme = Theme::updateOrCreate(
                ['id' => $request->id],
                [
                    'name'            => $request->name,
                    'tag_line'        => $request->tag_line,
                    'main_color'      => $request->main_color ?? '#3B82F6',
                    'top_color'       => $request->top_color ?? '#1E3A8A',
                    'secondary_color' => $request->secondary_color ?? '#64748B',
                    'custom_colors'   => $request->custom_colors ? json_encode(json_decode($request->custom_colors, true)) : null,
                    'logo'            => $logoPath,
                    'favicon'         => $faviconPath,
                    'is_active'       => $request->input('is_active', 1),
                ]
            );

            return response()->json([
                'status'  => 'success',
                'message' => $request->id ? 'Theme updated successfully!' : 'Theme added successfully!',
                'data'    => $theme
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($themeId)
    {
        $theme = Theme::findOrFail($themeId);
        return view('theme.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        //
    }
}
