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
        'duration',
        'university_fee',
        'university_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function courseMode()
    {
        return $this->belongsTo(CourseMode::class, 'mode_id');
    }


    public function subjects()
    {
        return $this->hasMany(Subject::class, 'subcourse_id');
    }


    public function students()
    {
        return $this->hasMany(\App\Models\Student::class, 'sub_course_id');
    }
    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }
}
