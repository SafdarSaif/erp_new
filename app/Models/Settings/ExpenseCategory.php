<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategory extends Model
{
      use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];
}
