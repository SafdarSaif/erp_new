<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Support\Facades\App;
use App\Models\Student;
use App\Models\Settings\Documents;

class StudentDocument extends Model
{
    protected $fillable = [
        'student_id',
        'document_id',
        'path',

    ];
    protected $casts = [
        'path' => 'array',   // JSON casting
    ];



    public function student()
    {
        return $this->belongsTo(Student::class);
    }

     public function document()
    {
        return $this->belongsTo(Documents::class, 'document_id');
    }




}
