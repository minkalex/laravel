<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * @param $userId
     * @return \Illuminate\Contracts\View\View
     */
    public function view($userId)
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
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $objUsers = User::orderBy('last_name')
            ->orderBy('name', 'asc')
            ->get();
        return view('authors')
            ->with('objUsers', $objUsers);
    }
}
