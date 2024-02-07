<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register');

Route::get('/users', function () {
    return view('users');
});


/**
 *
 *
 */

Route::get('/image/{name}', function ($name) {
//    return Storage::response(Storage::url('public/2c8fad31-1f0d-40e2-9502-b85418ebc939.jpg'));
    return $name;
});
