<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MembersController;

// Route untuk landing page
Route::get('/', [LandingPageController::class, 'index']);

// Route untuk menampilkan data members
Route::get('/members', [MembersController::class, 'index']);
