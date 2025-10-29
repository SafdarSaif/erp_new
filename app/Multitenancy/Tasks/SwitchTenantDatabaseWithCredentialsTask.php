<?php

namespace App\Multitenancy\Tasks;

use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;
use Illuminate\Support\Facades\DB;

class SwitchTenantDatabaseWithCredentialsTask implements SwitchTenantTask
{
    public function makeCurrent(IsTenant $tenant): void
    {
        
        config([
            'database.connections.tenant.database' => $tenant->database,
            'database.connections.tenant.username' => $tenant->db_username,
            'database.connections.tenant.password' => $tenant->db_password,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
        DB::setDefaultConnection('tenant');
    }

    public function forgetCurrent(): void
    {
        DB::purge('tenant');
    }
}
