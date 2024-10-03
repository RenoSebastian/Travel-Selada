<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NfcController;

Route::post('/members/checkin', [NfcController::class, 'checkin']);
Route::post('/members/checkout', [NfcController::class, 'checkout']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
