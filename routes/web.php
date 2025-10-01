<?php

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




