<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MiscellaneousFee extends Model
{
    protected $fillable = ['student_id','head','amount','semester'];

    public function student(){
        return $this->BelongsTo(Student::class,'student_id');
    }
}
