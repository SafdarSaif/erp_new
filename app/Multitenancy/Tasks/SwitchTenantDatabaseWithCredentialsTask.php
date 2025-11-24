<?php

namespace App\Multitenancy\Tasks;

use App\Models\Tenant;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SwitchTenantDatabaseWithCredentialsTask implements SwitchTenantTask
{
    public function makeCurrent(IsTenant $tenant): void
    {

        if (Session::has('selected_tenant_id')) {
            // dd('hello');
            $tanentData = Tenant::where('id', Session::get('selected_tenant_id'))->first();

            config([
                'database.connections.tenant.database' => $tanentData->database,
                'database.connections.tenant.username' => $tanentData->db_username,
                'database.connections.tenant.password' => $tanentData->db_password,
            ]);
        } else {
            config([
                'database.connections.tenant.database' => $tenant->database,
                'database.connections.tenant.username' => $tenant->db_username,
                'database.connections.tenant.password' => $tenant->db_password,
            ]);
        }

        DB::purge('tenant');
        DB::reconnect('tenant');
        DB::setDefaultConnection('tenant');
    }

    public function forgetCurrent(): void
    {
        DB::purge('tenant');
    }
}
