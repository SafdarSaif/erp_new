<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Academics\Course;;
use App\Models\Academics\SubCourse;
use App\Models\Student;

class University extends Model
{
    use HasFactory;

    protected $table = 'universities';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'logo'
    ];


    public function departments()
    {
        return $this->hasMany(\App\Models\Academics\Department::class, 'university_id', 'id');
    }
    public function courses()
    {
        return $this->hasMany(Course::class, 'university_id', 'id');
    }
    public function subCourses()
    {
        return $this->hasMany(SubCourse::class, 'university_id', 'id');
    }

    public function students()
{
    return $this->hasMany(Student::class);
}

}
