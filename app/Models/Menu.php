<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'is_parent',
        'url',
        'icon',
        'position',
        'permission',
        'is_active',
        'is_searchable',
    ];

    // Parent menu
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Child menus
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
