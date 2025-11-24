<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SwitchPanelController extends Controller
{
    /**
     * Return list of all tenants as JSON
     */
    public function index()
    {
        $tenants = Tenant::all();
        // dd($tenants);
        return response()->json($tenants);
    }

    /**
     * Switch to selected tenant panel
     */
    //     public function switchPanel($tenant)
    //     {

    //         $tenantData = Tenant::find($tenant->id);
    //         dd($tenantData);
    //         // Prevent invalid tenant
    //         // if (!$tenant || !$tenant->domain) {
    //         //     return back()->with('error', 'Invalid tenant or domain missing.');
    //         // }

    //         // // Detect protocol based on current request
    //         // $protocol = request()->isSecure() ? 'https://' : 'http://';

    //         // // Build redirect URL
    //         // $redirectUrl = $protocol . $tenant->domain . '/dashboard';

    //         // // Avoid redirect loop if same domain
    //         // if (request()->getHost() == $tenant->domain) {
    //         //     return back()->with('info', 'You are already on this panel.');
    //         // }

    //         // Redirect to tenant dashboard
    //         return redirect()->away($redirectUrl);
    //     }
    // }
    public function switchPanel($tenant)
    {
        // dd($tenant);
        session(['selected_tenant_id' => $tenant]);
        // 1. Fetch tenant by ID
        $tenantData = Tenant::find($tenant);

        // 2. Safety check
        if (!$tenantData) {
            return redirect()->back()->with('error', 'Tenant not found');
        }

        // 3. Set tenant DB config dynamically
        config([
            'database.connections.tenant.database' => $tenantData->database,
            'database.connections.tenant.username' => $tenantData->db_username,
            'database.connections.tenant.password' => $tenantData->db_password,
        ]);

        // 4. Reconnect to new DB
        DB::purge('tenant');
        DB::reconnect('tenant');
        DB::setDefaultConnection('tenant');

        // 5. Redirect to tenant dashboard (optional)
        return redirect('/dashboard');
    }
}
