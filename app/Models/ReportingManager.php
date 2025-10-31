<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportingManager extends Model
{
    protected $fillable = [
        'user_id',
        'reporting_user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to the manager (reporting user)
    public function manager()
    {
        return $this->belongsTo(User::class, 'reporting_user_id');
    }
}
