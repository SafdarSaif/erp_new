<?php

use App\Http\Controllers\Settings\AcademicYearController;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubCourseController;
use App\Http\Controllers\SubjectController;

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



Route::prefix('academics')->group(function () {
    // Universities
    Route::get('/university', [UniversityController::class, 'index'])->name('university.index');
    Route::get('/university/create', [UniversityController::class, 'create'])->name('university.create');
    Route::post('/university/store', [UniversityController::class, 'store'])->name('university.store');
    Route::get('/university/edit/{id}', [UniversityController::class, 'edit'])->name('university.edit');
    Route::post('/university/update/{id}', [UniversityController::class, 'update'])->name('university.update');
    Route::delete('/university/destroy/{id}', [UniversityController::class, 'destroy'])->name('university.destroy');
    Route::get('/university/status/{id}', [UniversityController::class, 'status'])->name('university.status');

    // Departments
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/department/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::post('/department/update/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/department/destroy/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
    Route::get('/department/status/{id}', [DepartmentController::class, 'status'])->name('department.status');

    // Courses
    Route::get('/course', [CourseController::class, 'index'])->name('course.index');
    Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
    Route::get('/course/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('/course/update/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/course/destroy/{id}', [CourseController::class, 'destroy'])->name('course.destroy');
    Route::get('/course/status/{id}', [CourseController::class, 'status'])->name('course.status');


    // Sub Courses
    Route::get('/subcourse', [SubCourseController::class, 'index'])->name('subcourse.index');
    Route::get('/subcourse/create', [SubCourseController::class, 'create'])->name('subcourse.create');
    Route::post('/subcourse/store', [SubCourseController::class, 'store'])->name('subcourse.store');
    Route::get('/subcourse/edit/{id}', [SubCourseController::class, 'edit'])->name('subcourse.edit');
    Route::post('/subcourse/update/{id}', [SubCourseController::class, 'update'])->name('subcourse.update');
    Route::delete('/subcourse/destroy/{id}', [SubCourseController::class, 'destroy'])->name('subcourse.destroy');
    Route::get('/subcourse/status/{id}', [SubCourseController::class, 'status'])->name('subcourse.status');
    // Subjects
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects/store', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/edit/{id}', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::post('/subjects/update/{id}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/destroy/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    Route::get('/subjects/status/{id}', [SubjectController::class, 'status'])->name('subjects.status');
});
