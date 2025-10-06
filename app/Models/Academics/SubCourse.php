<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'short_name', 'course_id', 'status', 'image'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
