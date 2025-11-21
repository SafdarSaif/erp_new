<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserDataObserver
{
    public static function addGlobalScope($model)
    {
        // Sirf User model ke liye apply kare
        if (!$model instanceof User) return;

        $model::addGlobalScope('role_downline_scope', function (Builder $builder) {

            if (!Auth::check()) return;

            $user = Auth::user();

            // ✅ Current user ke roles
            $userRoleIds = $user->roles->pluck('id')->toArray();

            // ✅ Roles downline from RoleReporting
            $downlineRoleIds = \App\Models\RoleReporting::whereIn('parent_id', $userRoleIds)
                                ->pluck('role_id')
                                ->toArray();
                                dd($downlineRoleIds);

            $allRoleIds = array_merge($userRoleIds, $downlineRoleIds);

            // ✅ Filter users based on allowed roles only
            $builder->whereHas('roles', function ($q) use ($allRoleIds) {
                $q->whereIn('id', $allRoleIds);
            });
        });
    }
}
