<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::resource('users', UserController::class);
Route::resource('chats', ChatController::class);
Route::resource('messages', MessageController::class);

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/signup', 'create');
    Route::post('/signup', 'store')->middleware('pass_match');
    Route::get('/', 'index')->name('main');
    Route::get('/profile', 'show')->name('profile');
    Route::get('/logout', 'logout')->name('logout');
});

Route::get('/chats/{chat}/participants', [ChatController::class, 'getParticipants']);
Route::get('/chat', [ChatController::class, 'index']);
Route::get('/messages?chat_id={chat_id}', [MessageController::class, 'index']);

/*Route::fallback(function () {
    return redirect()->route('main');
});*/
