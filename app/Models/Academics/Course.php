<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Academics\Department;
use App\Models\Settings\CourseType;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'course_type_id',
        'name',
        'image',
        'short_name',
        'status',
    ];

    /**
     * Get the department that owns the course.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the course type that owns the course.
     */
    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    // SubCourses under this course
    public function subCourses()
    {
        return $this->hasMany(SubCourse::class, 'course_id');
    }
}
