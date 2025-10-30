<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Settings\Religion;
use App\Models\Settings\Category;
use App\Models\Settings\Language;
use App\Models\Settings\BloodGroup;
use App\Models\Settings\AcademicYear;
use App\Models\Academics\University;
use App\Models\Settings\CourseType;
use App\Models\Academics\Course;
use App\Models\Academics\SubCourse;
use App\Models\Settings\AdmissionMode;
use App\Models\Settings\CourseMode;
use App\Models\Accounts\StudentFeeStructure;
use App\Models\Settings\Status;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'university_id',
        'course_type_id',
        'course_id',
        'sub_course_id',
        'admissionmode_id',
        'course_mode_id',
        'semester',
        'course_duration',
        'full_name',
        'father_name',
        'mother_name',
        'aadhaar_no',
        'email',
        'mobile',
        'language_id',
        'dob',
        'gender',
        'blood_group_id',
        'religion_id',
        'category_id',
        'income',
        'permanent_address',
        'current_address',
        'total_fee',
        'status',
        'status_id',
        'student_unique_id'
    ];

    // Relationships
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
    public function university()
    {
        return $this->belongsTo(University::class, 'university_id');
    }
    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function subCourse()
    {
        return $this->belongsTo(SubCourse::class, 'sub_course_id');
    }
    public function mode()
    {
        return $this->belongsTo(AdmissionMode::class, 'admissionmode_id ');
    }
    public function courseMode()
    {
        return $this->belongsTo(CourseMode::class, 'course_mode_id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class, 'blood_group_id');
    }
    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function fees()
    {
        return $this->hasMany(StudentFeeStructure::class);
    }

    public function ledger()
    {
        return $this->hasMany(StudentLedger::class);
    }

    public function feeStructures()
    {
        return $this->hasMany(StudentFeeStructure::class, 'student_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }


    public function queries()
{
    return $this->hasMany(StudentQuery::class, 'student_id', 'id');
}

}
