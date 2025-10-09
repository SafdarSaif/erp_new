<?php

use App\Http\Controllers\Settings\AcademicYearController;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/demo', function () {
    return view('content.datatable');
});

Route::get('/', function () {
    return view('content.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('content.home');
    })->name('dashboard');
});





Route::get('menu', function () {
    return view('menu.index');
});
Route::get('/menus/data', function () {
    $menus = Menu::with('parent')->get();

    $data = $menus->map(function ($menu) {
        return [
            "id"         => $menu->id,
            "name"       => $menu->name,
            "url"        => $menu->url,
            "icon"       => $menu->icon,
            "position"   => $menu->position,
            "parent"     => $menu->parent?->name ?? '--',
            "is_active"  => $menu->is_active ? "Active" : "Inactive",
            "is_searchable" => $menu->is_searchable ? "Yes" : "No",
            "created_at" => $menu->created_at->format('Y-m-d'),
        ];
    });

    return response()->json($data);
});


Route::prefix('settings')->group(function () {
    Route::get('/academicyears', [AcademicYearController::class, 'index'])->name('academicyears');
    Route::post('/academicyears', [AcademicYearController::class, 'store'])->name('academicyears');
    Route::put('/academicyears/{id}', [AcademicYearController::class, 'update'])->name('academicyears.update');
    Route::get('/academicyears/create', [AcademicYearController::class, 'create'])->name('academicyears.create');
    Route::get('/academicyears/edit/{id}', [AcademicYearController::class, 'edit'])->name('academicyears.edit');
    Route::get('/academicyears/status/{id}', [AcademicYearController::class, 'status'])->name('academicyears.status');
    Route::delete('/academicyears/delete/{id}', [AcademicYearController::class, 'delete'])->name('academicyears.delete');
});


    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
    Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/destroy/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::get('menu/status/{id}', [MenuController::class, 'status'])->name('menu.status');

    Route::get('/theme', [ThemeController::class, 'index'])->name('theme.index');
    Route::get('/theme/create', [ThemeController::class, 'create'])->name('theme.create');
    Route::post('/theme/store', [ThemeController::class, 'store'])->name('theme.store');
    Route::get('/theme/edit/{id}', [ThemeController::class, 'edit'])->name('theme.edit');
    Route::post('/theme/update/{id}', [ThemeController::class, 'update'])->name('theme.update');
    Route::delete('/theme/destroy/{id}', [ThemeController::class, 'destroy'])->name('theme.destroy');
    Route::get('theme/status/{id}', [ThemeController::class, 'status'])->name('theme.status');



// Users
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// Roles & Permissions
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
Route::get('/users/permissions/create', [PermissionController::class, 'create'])->name('users.permissions.create');
Route::post('/users/permissions', [PermissionController::class, 'store'])->name('users.permissions');



// Roles
Route::get('/users/roles', [RoleController::class, 'index'])->name('users.roles');
Route::get('/users/roles/create', [RoleController::class, 'create'])->name('users.roles.create');
Route::post('/users/roles', [RoleController::class, 'store'])->name('users.roles');
Route::get('/users/roles/edit/{id}', [RoleController::class, 'edit'])->name('users.roles.edit');
Route::post('/users/roles/update', [RoleController::class, 'update'])->name('users.roles.update');




