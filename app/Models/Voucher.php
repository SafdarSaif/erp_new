<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\ExpenseCategory;

class Voucher extends Model
{
    protected $fillable = [
        'voucher_type',
        'other_type',
        'date',
        'expense_category_id',
        'amount',
        'payment_mode',
        'description',
        'attachment',
        'added_by',
    ];

    /**
     * Relationship: Voucher belongs to Expense Category
     */
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
}
