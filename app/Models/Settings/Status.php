<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Status extends Model
{
     use HasFactory;

    protected $fillable = ['name', 'status'];
}
