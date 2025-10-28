<?php

namespace App\TenantFinders;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class SubdomainTenantFinder extends TenantFinder
{
    public function findForRequest(Request $request): ?IsTenant
    {
        $host = $request->getHost(); // school1.localhost

        $mainDomain = 'localhost'; // ← LOCAL DEV DOMAIN FIXED

        if (!str_contains($host, $mainDomain)) {
            return null;
        }

        $subdomain = str_replace('.' . $mainDomain, '', $host); // school1

        return Tenant::where('subdomain', $subdomain)->first();
    }
}
