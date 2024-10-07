<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\LoginController;


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginApk'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/landing', [LandingPageController::class, 'index'])->name('landing');

Route::get('/limited-dashboard', function () {
    return view('limited_dashboard');
})->name('limited_dashboard');

Route::get('/members', [MembersController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


