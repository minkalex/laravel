<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * @param $userId
     * @return View
     */
    public function view($userId): View
    {
        $objPosts = Post::where('user_id', $userId)->orderByDesc('created_at')->get();
        $user = User::find($userId)->full_name;
        return view('posts')
            ->with('user', $user)
            ->with('objPosts', $objPosts);
    }

    /**
     * View for index page
     *
     * @return View
     */
    public function index(): View
    {
        $objUsers = User::orderBy('last_name')
            ->orderBy('name', 'asc')
            ->get();
        return view('authors')
            ->with('objUsers', $objUsers);
    }
}
