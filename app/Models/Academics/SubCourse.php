<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Academics\Course;
use App\Models\Settings\CourseMode;


class SubCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mode_id',
        'short_name',
        'course_id',
        'status',
        'image',
        'duration'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function courseMode()
    {
         return $this->belongsTo(CourseMode::class, 'mode_id');
    }
}
