<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/token', [TokenController::class, 'create']);

Route::resource('/users', UserController::class)->only(['index', 'store', 'show']);

Route::get('/test', [TokenController::class, 'test']);
