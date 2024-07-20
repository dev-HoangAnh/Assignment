<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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
    return view('client/index');
});

Route::get('/post-details', function () {
    return view('client/post-details');
});

Route::get('/search-result', function () {
    return view('client/search-result');
});

Route::get('/search-not-found', function () {
    return view('client/search-not-found');
});

Route::get('/tags', function () {
    return view('client/tags');
});



// // Auth routes
// Route::post('/register', [AuthController::class, 'register'])->name('register');
// Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
// Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

