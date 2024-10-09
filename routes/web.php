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

// Rute untuk Input Data Brand
Route::get('/admin/brand/input', [BrandController::class, 'create'])->name('brand.create');
// Rute untuk menyimpan data brand
Route::post('/admin/brand', [BrandController::class, 'store'])->name('brand.store');

