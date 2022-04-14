<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PostController::class, 'index'])->name('main');
Route::get('/user/{user_id}', [PostController::class, 'view']);

Route::get('/profile', [UsersController::class, 'profile'])->name('profile');

Route::get('/login', [UsersController::class, 'showLoginForm']);
Route::post('/login', [UsersController::class, 'authenticate']);

Route::get('/signup', [UsersController::class, 'showSingUoForm']);
Route::post('/registration', [UsersController::class, 'registration'])->middleware('pass_match');

Route::fallback(function () {
    return redirect()->route('main');
});
