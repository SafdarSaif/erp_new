<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Settings\ExpenseCategory;
use Illuminate\Support\Facades\Validator;
use Exception;


class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $vouchers = Voucher::with('expenseCategory')->orderBy('id', 'desc')->get();

            return DataTables::of($vouchers)
                ->addIndexColumn()
                ->editColumn('expense_category_id', fn($row) => $row->expenseCategory->name ?? '-')
                ->editColumn('amount', fn($row) => number_format($row->amount, 2))
                ->editColumn('status', fn($row) => $row->status ?? 'Pending Approval')
                ->addColumn('action', fn($row) => '')
                ->make(true);
        }

        return view('accounts.vouchers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenseCategories  = ExpenseCategory::where('status', 1)->get();
        return view('accounts.vouchers.create', compact('expenseCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'voucher_type' => 'required|string|max:255',
            'date' => 'required|date',
            'expense_category_id' => 'nullable|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'errors' => $validator->errors()], 422);
        }

        try {
            $voucher = new Voucher();
            $voucher->voucher_type = $request->voucher_type;
            $voucher->date = $request->date;
            $voucher->expense_category_id = $request->expense_category_id;
            $voucher->amount = $request->amount;
            $voucher->payment_mode = $request->payment_mode;
            $voucher->description = $request->description;



            // ✅ Handle attachment uploadapp
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/vouchers'), $filename);
                $voucher->attachment = 'uploads/vouchers/' . $filename;
            }

            // $voucher->status = 'Pending Approval';
            $voucher->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Voucher created successfully.',
                'data' => $voucher
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
    // public function show(Voucher $voucher)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        $expenseCategories = ExpenseCategory::where('status', 1)->get();
        return view('accounts.vouchers.edit', compact('voucher', 'expenseCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        // ✅ Validate input
        $validator = Validator::make($request->all(), [
            'voucher_type' => 'required|string|max:255',
            'date' => 'required|date',
            'expense_category_id' => 'nullable|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // ✅ Update fields
            $voucher->voucher_type = $request->voucher_type;
            $voucher->date = $request->date;
            $voucher->expense_category_id = $request->expense_category_id;
            $voucher->amount = $request->amount;
            $voucher->payment_mode = $request->payment_mode;
            $voucher->description = $request->description;

            // ✅ Handle attachment update
            if ($request->hasFile('attachment')) {
                // Delete old file if exists
                if ($voucher->attachment && file_exists(public_path($voucher->attachment))) {
                    unlink(public_path($voucher->attachment));
                }

                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/vouchers'), $filename);
                $voucher->attachment = 'uploads/vouchers/' . $filename;
            }

            $voucher->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Voucher updated successfully.',
                'data' => $voucher
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        //
    }


    public function show($id)
    {
        $voucher = Voucher::with('expenseCategory')->findOrFail($id);

        return view('accounts.vouchers.view', compact('voucher'));
    }



   public function status(Request $request, $id)
{
    try {
        $voucher = Voucher::findOrFail($id);

        if ($request->action === 'approve') {
            $voucher->status = 1;
            $message = 'Voucher approved successfully!';
        } elseif ($request->action === 'reject') {
            $voucher->status = 2;
            $message = 'Voucher rejected successfully!';
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid action']);
        }

        $voucher->save();

        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong: ' . $e->getMessage(),
        ]);
    }
}

}
