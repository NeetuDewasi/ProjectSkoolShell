<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect('/login');
})->name('index');

Auth::routes();

Route::get('login', function () {
    if(Auth::check()) {
        if (auth()->user()->role->role == 'admin' || auth()->user()->role->role == "Administrator") {
            return redirect('/admin/dashboard');
        }else if (auth()->user()->role->role == 'school') {
            return redirect('/school/dashboard');
        }
    }
    return view('index');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::any('admin/{page?}', function () {
        return view('admin.layouts.app');
    })->where('page', '(.*)');

    Route::any('school/{page?}', function () {
        return view('school.layouts.app');
    })->where('page', '(.*)');
});

Route::any('{page?}', function () {
    return redirect(route('index'));
})->where('page', '(.*)');
