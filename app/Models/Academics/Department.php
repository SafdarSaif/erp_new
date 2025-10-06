<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'university_id',
        'status'
    ];

    // Relationship to University
    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
