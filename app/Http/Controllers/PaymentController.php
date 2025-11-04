<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Voucher;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $payments = Payment::with('voucher')->orderBy('id', 'desc')->get();

    //         $vocher_expense_category_id = Voucher::with('expenseCategory')             ->whereNotNull('expense_category_id')
    //             ->pluck('expense_category_id')
    //             ->toArray();
    //         // dd($payments->toArray());
    //         return DataTables::of($payments)
    //             ->addIndexColumn()
    //             ->addColumn('voucher_type', fn($row) => $row->voucher->voucher_type ?? '-')
    //             ->addColumn('category', fn($row) => $vocher_expense_category_id ?? '-')
    //             ->addColumn('amount', fn($row) => $row->voucher->amount ?? '-')
    //             ->addColumn('payment_mode', fn($row) => $row->voucher->payment_mode ?? '-')
    //             ->addColumn('date', fn($row) => $row->voucher->date ? date('d M Y', strtotime($row->voucher->date)) : '-')
    //             ->addColumn('status', fn($row) => $row->status == 0
    //                 ? '<span class="badge bg-warning text-dark">Pending</span>'
    //                 : '<span class="badge bg-success">Closed</span>')
    //             ->addColumn('action', function ($row) {
    //                 if ($row->status == 0) {
    //                     return '<button class="btn btn-sm btn-success mark-paid" data-id="' . $row->id . '">
    //                                 <i class="ri-check-line me-1"></i> Paid
    //                             </button>';
    //                 } else {
    //                     return '<span class="badge bg-secondary">Closed</span>';
    //                 }
    //             })
    //             ->rawColumns(['status', 'action'])
    //             ->make(true);
    //     }

    //     return view('accounts.payment.index');
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // ✅ Load voucher + expense category efficiently
            $payments = Payment::with(['voucher.expenseCategory'])
                ->orderByDesc('id');

            return DataTables::of($payments)
                ->addIndexColumn()

                // ✅ Voucher Type
                ->addColumn('voucher_type', function ($row) {
                    return $row->voucher->voucher_type ?? '-';
                })

                // ✅ Expense Category (from relation)
                ->addColumn('category', function ($row) {
                    return $row->voucher && $row->voucher->expenseCategory
                        ? $row->voucher->expenseCategory->name
                        : '-';
                })

                // ✅ Amount
                ->addColumn('amount', function ($row) {
                    return $row->voucher->amount ?? '-';
                })

                // ✅ Payment Mode
                ->addColumn('payment_mode', function ($row) {
                    return $row->voucher->payment_mode ?? '-';
                })

                // ✅ Date Formatting
                ->addColumn('date', function ($row) {
                    return $row->voucher && $row->voucher->date
                        ? date('d M Y', strtotime($row->voucher->date))
                        : '-';
                })

                // ✅ Action Button
                ->addColumn('action', function ($row) {
                    $user = auth()->user();

                    if ($user && $user->can('approve payment')) {
                        if ($row->status == 0) {
                            return '<button class="btn btn-sm btn-success mark-paid" data-id="' . $row->id . '">
                        <i class="ri-check-line me-1"></i> Paid
                    </button>';
                        } else {
                            return '<span class="badge bg-secondary">Closed</span>';
                        }
                    }

                    // if user has no permission
                    return '<span class="badge bg-light text-muted"></span>';
                })


                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('accounts.payment.index');
    }

    // ✅ When "Paid" button clicked
    public function updateStatus($id, Request $request)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['status' => 'error', 'message' => 'Payment not found.']);
        }

        $payment->status = $request->status ?? 1;
        $payment->added_by = Auth::user()->id;
        $payment->save();

        return response()->json(['status' => 'success', 'message' => 'Payment marked as Paid successfully.']);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
