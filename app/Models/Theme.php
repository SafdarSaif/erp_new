<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tag_line',
        'main_color',
        'top_color',
        'secondary_color',
        'custom_colors',
        'logo',
        'favicon',
        'is_active',
    ];
}
