<?php

namespace App\Models;

use App\Models\Academics\Course;
use App\Models\Academics\University;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityFees extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'university_id',
        'course_id',
        'transaction_id',
        'amount',
        'status',
        'date',
        'mode'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
