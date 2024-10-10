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
use App\Http\Controllers\UserLocationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusController;

use App\Http\Controllers\MBusController;

// Route untuk m_bus
Route::prefix('m_bus')->group(function () {
    Route::get('create', [MBusController::class, 'create'])->name('m_bus.create');
    Route::post('store', [MBusController::class, 'store'])->name('m_bus.store');
    Route::get('/', [MBusController::class, 'index'])->name('m_bus.index');
    
    // Route untuk edit
    Route::get('{id}/edit', [MBusController::class, 'edit'])->name('m_bus.edit');
    Route::put('{id}', [MBusController::class, 'update'])->name('m_bus.update');
    Route::delete('{id}', [MBusController::class, 'destroy'])->name('m_bus.destroy');
});

Route::get('/bus/create', [BusController::class, 'create'])->name('bus.create'); // Menampilkan form
Route::post('/bus/store', [BusController::class, 'store'])->name('bus.store');

Route::get('/bus', [BusController::class, 'index'])->name('bus.index');

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

Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// Route untuk halaman input user location baru
Route::get('/user-locations/create', [UserLocationController::class, 'create'])->name('user_locations.create');
Route::post('/user-locations', [UserLocationController::class, 'store'])->name('user_locations.store');
Route::get('/user-locations/list_user-locations', [UserLocationController::class, 'index'])->name('user_locations.index');
