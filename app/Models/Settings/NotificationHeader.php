<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class NotificationHeader extends Model
{
    protected $fillable = ['name','status'];

    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class, 'header_id');
    // }
}
