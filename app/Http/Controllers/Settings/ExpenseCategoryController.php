<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\ExpenseCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class ExpenseCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = ExpenseCategory::orderBy('id', 'desc')->get();

            return DataTables::of($categories)
                ->addIndexColumn()
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('Settings.expensecategory.index');
    }

    public function create()
    {
        return view('Settings.expensecategory.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:expense_categories,name',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $category = new ExpenseCategory();
            $category->name = $request->name;
            $category->description = $request->description ?? null;
            $category->status = $request->has('status') ? $request->status : 1;
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Expense category created successfully.',
                'data' => $category
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $expensecategory  = ExpenseCategory::findOrFail($id);
        return view('Settings.expensecategory.edit', compact('expensecategory'));
    }

    public function update(Request $request, $id)
    {
        try {
            $category = ExpenseCategory::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:expense_categories,name,' . $category->id,
                'description' => 'nullable|string',
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $category->update([
                'name' => $request->name,
                'description' => $request->description ?? $category->description,
                'status' => $request->has('status') ? $request->status : $category->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Expense category updated successfully.',
                'data' => $category,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            ExpenseCategory::destroy($id);
            return ['status' => 'success', 'message' => 'Expense category deleted successfully!'];
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function status($id)
    {
        try {
            $category = ExpenseCategory::findOrFail($id);
            $category->status = $category->status == 1 ? 0 : 1;
            $category->save();

            return response()->json([
                'status' => 'success',
                'message' => $category->name . ' status updated successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
