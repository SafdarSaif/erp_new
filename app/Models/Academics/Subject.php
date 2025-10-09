<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Academics\SubCourse;

class Subject extends Model
{
use HasFactory;

    protected $fillable = [
        'subcourse_id',
        'name',
        'code',
        'status',
    ];

    public function subcourse()
    {
        return $this->belongsTo(SubCourse::class);
    }
}
