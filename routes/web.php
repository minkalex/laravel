<?php

use App\Http\Controllers\BlogController;
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

Route::middleware(['check_auth'])->group(function () {
    Route::get('/profile', [UsersController::class, 'show'])->name('profile');
    Route::get('/logout', [UsersController::class, 'logout'])->name('logout');

    Route::controller(PostController::class)->group(function () {
        Route::get('/post/add', 'showPostForm');
        Route::post('/post/add', 'store');
        Route::get('/posts', 'getPostsOrderByDateDesc')->name('all_user_posts');

        //Route::get('/user/{user_id}/posts/{post_id}/edit', 'edit');
        //Route::put('/user/{user_id}/post/{post_id}/edit', 'edit');
        //Route::delete('/user/{user_id}/post/{post_id}/delete', 'destroy');
    });

    Route::post('/user/{user_id}', [CommentController::class, 'store']);
});

Route::resource('posts', PostController::class)->only([
    'edit', 'update', 'destroy'
]);

Route::controller(UsersController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/signup', 'create');
    Route::post('/signup', 'store')->middleware('pass_match');
});

Route::controller(PostController::class)->group(function () {
    Route::get('/', 'index')->name('main');
    Route::get('/user/{user_id}', 'view');
});

Route::fallback(function () {
    return redirect()->route('main');
});
