<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::get('/token', [TokenController::class, 'create']);

Route::get('/positions', [PositionController::class, 'index']);

Route::resource('/users', UserController::class)->only(['index', 'store', 'show']);
