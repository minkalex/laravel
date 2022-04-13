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

Route::get('/users/{id}', [PostController::class, 'view']);
Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/login', [UsersController::class, 'login']);
Route::post('/validation', [UsersController::class, 'authenticate']);

Route::get('/signup', [UsersController::class, 'create']);
Route::post('/registration', [UsersController::class, 'store']);

Route::fallback(function () {
    return redirect()->route('main');
});
