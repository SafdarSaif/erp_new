<?php

namespace App\Models\Accounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Student;
use App\Models\StudentLedger;

use Illuminate\Database\Eloquent\Model;

class StudentFeeStructure extends Model
{
    use HasFactory;

    protected $table = 'student_fee_structures';

    protected $fillable = [
        'student_id',
        'semester',
        'amount',
    ];

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function ledgers()
    {
        return $this->hasMany(StudentLedger::class, 'student_fee_id');
    }
}
