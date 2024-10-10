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
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;

// Rute untuk halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::group(['middleware' => ['check.username']], function () {
    Route::get('/admin/dashboard', 'AdminDashboardController@index')->name('admin.dashboard');
});


Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

Route::get('/locations', [LocationController::class, 'showForm'])->name('locations.form');
Route::post('/locations', [LocationController::class, 'getLocations'])->name('locations.index');

Route::get('/locations/list/Bus', [LocationController::class, 'index'])->name('location.index');
Route::get('/locations/create', [LocationController::class, 'create'])->name('location.create');
Route::post('/locations/store', [LocationController::class, 'store'])->name('location.store');

// Route untuk halaman input user baru
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/list_user', [UserController::class, 'index'])->name('users.index');



