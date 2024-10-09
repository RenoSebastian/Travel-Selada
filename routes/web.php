<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LocationController;

// Rute untuk halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Tambahkan rute admin lainnya di sini
});


// Rute untuk user
Route::middleware([UserMiddleware::class])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});
Route::get('/locations', [LocationController::class, 'showForm'])->name('locations.form');
Route::post('/locations', [LocationController::class, 'getLocations'])->name('locations.index');
