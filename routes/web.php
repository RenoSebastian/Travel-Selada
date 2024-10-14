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

use App\Http\Controllers\UserTravelController;

use App\Http\Controllers\RoleController;

use App\Http\Controllers\PesertaTourController;

Route::prefix('peserta-tour')->group(function () {
    Route::get('/', [PesertaTourController::class, 'index'])->name('peserta_tour.index');
    Route::get('/create/{bus_id}', [PesertaTourController::class, 'create'])->name('peserta_tour.create');
    Route::post('/store/{bus_id}', [PesertaTourController::class, 'store'])->name('peserta_tour.store');
    Route::get('/edit/{id}', [PesertaTourController::class, 'edit'])->name('peserta_tour.edit');
    Route::put('/update/{id}', [PesertaTourController::class, 'update'])->name('peserta_tour.update');
    Route::delete('/destroy/{id}', [PesertaTourController::class, 'destroy'])->name('peserta_tour.destroy');
});


Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

Route::prefix('user_travel')->group(function () {
    Route::get('/', [UserTravelController::class, 'index'])->name('user_travel.index');
    Route::get('create', [UserTravelController::class, 'create'])->name('user_travel.create');
    Route::post('store', [UserTravelController::class, 'store'])->name('user_travel.store');
    Route::get('/{id}', [UserTravelController::class, 'edit'])->name('user_travel.edit');
    Route::put('/{id}', [UserTravelController::class, 'update'])->name('user_travel.update');
    Route::delete('/{id}', [UserTravelController::class, 'destroy'])->name('user_travel.destroy');
});
Route::get('/user_travel/create_tour_leader', [UserTravelController::class, 'createTourLeader'])->name('user_travel.create_tour_leader');
Route::post('/user_travel/store_tour_leader', [UserTravelController::class, 'storeTourLeader'])->name('user_travel.store_tour_leader');

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
// Route untuk Bus
Route::prefix('bus')->group(function () {
    Route::get('/', [BusController::class, 'index'])->name('bus.index');
    Route::get('/create', [BusController::class, 'create'])->name('bus.create');
    Route::post('/store', [BusController::class, 'store'])->name('bus.store');
    Route::get('/edit/{id}', [BusController::class, 'edit'])->name('bus.edit');
    Route::put('/update/{id}', [BusController::class, 'update'])->name('bus.update');
    Route::delete('/destroy/{id}', [BusController::class, 'destroy'])->name('bus.destroy');
});

// Rute untuk halaman login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register');

// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::group(['middleware' => ['check.username']], function () {
    
});

Route::get('/admin/dashboard', 'AdminDashboardController@index')->name('admin.dashboard');

Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

Route::get('/locations', [LocationController::class, 'showForm'])->name('locations.form');
Route::post('/locations', [LocationController::class, 'getLocations'])->name('peserta.index');

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
