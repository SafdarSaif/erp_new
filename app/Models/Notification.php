<?php

namespace App\Models;

use App\Models\Settings\NotificationHeader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    // Table name (optional if following Laravel convention)
    protected $table = 'notifications';

    // Mass assignable fields
    protected $fillable = [
        'header_id',
        'send_to',
        'title',
        'description',
        'added_by',
    ];

    // Relationships

    // Notification Header
    public function header()
    {
        return $this->belongsTo(NotificationHeader::class, 'header_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'added_by');
    }

    // Optional: Accessor to display human-readable send_to
    public function getSendToTextAttribute()
    {
        return $this->send_to === 'users' ? 'Users' : 'Students';
    }
}
