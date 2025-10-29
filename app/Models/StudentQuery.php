<?php

namespace App\Models;

use App\Models\Settings\QueryHead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuery extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'query_head_id',
        'query',
        'attachment',
        'answer',
        'status',
    ];

    public function queryHead()
    {
        return $this->belongsTo(QueryHead::class, 'query_head_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
