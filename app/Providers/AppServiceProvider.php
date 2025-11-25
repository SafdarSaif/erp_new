<?php

namespace App\Providers;

use App\Http\Controllers\MenuController;
use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

//  Add these imports
use App\Models\{
    Academics\University,
    Academics\Department,
    Academics\Course,
    Academics\SubCourse,
    Academics\Subject,
    Student,
    StudentInvoice,
    Accounts\StudentFeeStructure,
    MiscellaneousFee,
    Report,
    StudentLedger,
    UniversityFees,
    StudentQuery,
    Voucher,
    // User,
};
use App\Observers\UserDataObserver;
use Illuminate\Support\Facades\Auth;

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

        // if (!Auth::check()) {
        //     redirect()->to('/login')->send();
        // }

        View::composer('*', function ($view) {

            $menus = Menu::whereNull('parent_id')
                ->where('is_active', 1)
                ->with('children')
                ->orderBy('position', 'asc')
                ->get()
                ->toArray();
            $view->with('menus', $menus);
        // });



        // ---- SESSION EXPIRY TIMER ----
       // ADD SESSION EXPIRY TIME HERE
        $sessionLifetime = config('session.lifetime'); // minutes
        $expiryTimestamp = now()->addMinutes($sessionLifetime)->timestamp;

        $view->with('sessionExpiry', $expiryTimestamp);
    });

        $models = [
            // University::class,
            Department::class,
            // Course::class,
            // SubCourse::class,
            Subject::class,
            Student::class,
            StudentInvoice::class,
            StudentFeeStructure::class,
            MiscellaneousFee::class,
            Report::class,
            StudentLedger::class,
            UniversityFees::class,
            StudentQuery::class,
            Voucher::class,
            // User::class
        ];
        // dd($models);
        foreach ($models as $model) {
            $model::observe(UserDataObserver::class);

            UserDataObserver::addGlobalScope($model);
        }



    }
}
