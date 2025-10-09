<?php

namespace App\Http\Controllers\Settings;

use App\Models\Settings\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $category = Category::orderBy('id', 'desc')->get();
            return DataTables::of($category)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Settings.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
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
            // Create Category
            $category = new Category();
            $category->name = $request->name;
            $category->status = $request->has('status') ? $request->status : 1;
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => $category
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($categoryID)
    {
        $category = Category::findOrFail($categoryID);
        return view('Settings.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $categoryID)
    {
        try {
            // Find the Category
            $category = Category::findOrFail($categoryID);

            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            // Update Category
            $category->update([
                'name' => $request->name,
                'status' => $request->has('status') ? $request->status : $category->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully.',
                'data' => $category,
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
  public function destroy($categoryID)
    { {
            try {
                $category = Category::destroy($categoryID);
                return ['status' => 'success', 'message' => 'Category deleted successfully!'];
            } catch (\Throwable $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
    public function status($id)
    {
        try {
            $category = Category::findOrFail($id);
            if ($category) {
                $category->status = $category->status == 1 ? 0 : 1;
                $category->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $category->name . ' status updated successfully!',
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
