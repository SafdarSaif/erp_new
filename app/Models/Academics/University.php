<?php

namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

}
