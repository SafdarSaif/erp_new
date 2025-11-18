<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentQualification extends Model
{
   protected $fillable = [
        'student_id',
        'qualification',
        'board',
        'passing_year',
        'marks',
        'result',
        'document',
    ];


    public function student()
{
    return $this->belongsTo(Student::class, 'student_id');
}

}
