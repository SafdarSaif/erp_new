<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserDataObserver
{
    /**
     * Automatically assign added_by when creating a record.
     */

    public function creating($model)
    {
        if (Auth::check() && !$model->added_by) {
            $model->added_by = Auth::id();
        }
    }

    /**
     * Apply global user-based filtering to all selects.
     */

    public static function addGlobalScope($model)
    {
        $model::addGlobalScope('added_by_scope', function (Builder $builder) {
            if (Auth::check()) {
                $user = Auth::user();

                // Allow superadmin to see all records
                if (!$user->hasRole('Super Admin')) {
                    $builder->where($builder->getModel()->getTable() . '.added_by', $user->id);
                }
            }
        });
    }
}
