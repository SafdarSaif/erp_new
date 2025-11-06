<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Voucher;
use App\Models\Settings\ExpenseCategory;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'voucher_id',
        'user_by',
        'added_by',
        'status',
    ];
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id', 'id');
    }

    // 🔹 Each payment has one expense category through the voucher
    // public function expenseCategory()
    // {
    //     return $this->hasOneThrough(
    //         \App\Models\Settings\ExpenseCategory::class,
    //         \App\Models\Voucher::class,
    //         'id',                   // Foreign key on vouchers table
    //         'id',                   // Foreign key on expense_categories table
    //         'voucher_id',           // Local key on payments table
    //         'expense_category_id'   // Local key on vouchers table
    //     );
    // }

    public function expenseCategory()
{
    return $this->hasOne(ExpenseCategory::class, 'id', 'expense_category_id')
        ->whereHas('voucher', function ($query) {
            $query->whereColumn('vouchers.id', 'payments.voucher_id');
        });
}
}
