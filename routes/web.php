<?php

use App\Http\Controllers\CommentController;
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

Route::resource('posts', PostController::class)->only([
    'edit', 'update', 'destroy'
]);

Route::resource('comments', CommentController::class)->only([
    'destroy'
]);

Route::resource('users', UsersController::class)->only([
    'edit', 'update'
]);

Route::controller(UsersController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/signup', 'create');
    Route::post('/signup', 'store')->middleware('pass_match');
    Route::get('/', 'index')->name('main');
    Route::get('/profile', 'show')->name('profile');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(PostController::class)->group(function () {
    Route::get('/post/add', 'showPostForm');
    Route::post('/post/add', 'store');
    Route::get('/posts', 'showPostsInAdmin')->name('all_user_posts');
    Route::get('/user/{user_id}', 'showUserPosts');
});

Route::controller(CommentController::class)->group(function () {
    Route::post('/user/{user_id}', 'store');
    Route::post('/posts', 'store');
});

Route::view('/test', 'test_vue');

Route::fallback(function () {
    return redirect()->route('main');
});
