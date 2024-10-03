<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NfcController;

Route::post('/nfc/check', [NfcController::class, 'checkNfcTag']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
