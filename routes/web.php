<?php

use App\Http\Controllers\Settings\AcademicYearController;
use Illuminate\Support\Facades\Route;

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


Route::get('/datatable/data', function () {
    return response()->json([
        [
            "id" => 1,
            "full_name" => "John Doe",
            "designation" => "Developer",
            "email" => "john@example.com",
            "start_date" => "2024-01-01",
            "salary" => "50000",
            "age" => 28,
            "avatar_image" => "https://via.placeholder.com/40"
        ]
    ]);
});


Route::prefix('settings')->group(function(){
    Route::get('/academicyears',[AcademicYearController::class,'index'])->name('academicyears');
    Route::post('/academicyears',[AcademicYearController::class,'store'])->name('academicyears');
    Route::put('/academicyears/{id}',[AcademicYearController::class,'update'])->name('academicyears.update');
    Route::get('/academicyears/create',[AcademicYearController::class,'create'])->name('academicyears.create');
    Route::get('/academicyears/edit/{id}',[AcademicYearController::class,'edit'])->name('academicyears.edit');
    Route::get('/academicyears/status/{id}', [AcademicYearController::class, 'status'])->name('academicyears.status');
    Route::delete('/academicyears/delete/{id}', [AcademicYearController::class, 'delete'])->name('academicyears.delete');
});


