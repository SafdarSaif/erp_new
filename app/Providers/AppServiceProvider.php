<?php

namespace App\Providers;

use App\Http\Controllers\MenuController;
use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
        // $menus = MenuController::getMenuHierarchy(Menu::where('is_active', 1)->get());

        // $view->with('menus', $menus);
        // //
          $menus = Menu::whereNull('parent_id')       // top-level menus only
        ->where('is_active', 1)                 // only active menus
        ->with('children')                       // eager load active children
        ->orderBy('position', 'asc')
        ->get()
        ->toArray();
        $view->with('menus', $menus);
     });



    }
}
