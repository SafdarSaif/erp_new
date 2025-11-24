<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Spatie\Multitenancy\Models\Concerns\HasDatabase;

class Tenant extends BaseTenant
{
    //  use HasDatabase;
    protected $fillable = [
        'name',
        'subdomain',
        'domain',
        'database',
        'db_username',
        'db_password'
    ];
}
