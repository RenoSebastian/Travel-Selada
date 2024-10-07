<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware(AdminMiddleware::class); // Hanya admin yang bisa akses

    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard'); // Semua pengguna bisa akses
});

// Routes for different roles
Route::get('/screen-a', function () {
    return view('role1'); // View untuk role_id 1
})->name('screen.a');

Route::get('/screen-b', function () {
    return view('role2'); // View untuk role_id 2
})->name('screen.b');

Route::get('/landing', [LandingPageController::class, 'index'])->name('landing');

Route::get('/limited-dashboard', function () {
    return view('limited_dashboard');
})->name('limited_dashboard');

Route::get('/members', [MembersController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');



