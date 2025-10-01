<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;

public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();

    // Flash success message
    Session::flash('status', 'Login successful!');

    return redirect()->intended(RouteServiceProvider::HOME); // usually '/dashboard'
}
