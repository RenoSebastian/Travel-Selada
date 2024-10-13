<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NfcController;
use App\Http\Controllers\LocationController;

Route::post('auth/login', [LoginController::class, 'loginApk']);
Route::post('auth/register/member', [LoginController::class, 'registerApk']);
Route::post('/members/checkin', [NfcController::class, 'checkin']);
Route::post('/members/checkout', [NfcController::class, 'checkout']);
Route::post('/members/checkoutAll', [NfcController::class, 'checkoutAll']);
Route::post('member/locations', [LocationController::class, 'getLocations'])->name('locations.index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
