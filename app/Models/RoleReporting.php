<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\Role;

class RoleReporting extends Model
{
    protected $fillable = [
        'role_id',
        'parent_id',
    ];

    // Relationship with Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function parentRole()
    {
        return $this->belongsTo(Role::class, 'parent_id');
    }

}
