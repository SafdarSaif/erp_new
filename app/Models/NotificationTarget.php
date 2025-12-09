<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTarget extends Model
{
    protected $fillable = [
        'notification_id',
        'target_type',
        'target_id',
        'email',
    ];
}
