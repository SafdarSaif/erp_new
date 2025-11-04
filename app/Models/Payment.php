<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
