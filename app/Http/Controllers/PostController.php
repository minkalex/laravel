<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            ->select('users.id', 'last_name', 'name')
            ->orderBy('name', 'asc')
            ->join('posts', function ($join) {
                $join->on('users.id', 'posts.user_id');
            })
            ->groupBy('users.id')
            ->get();
        return view('authors')
            ->with('objUsers', $objUsers);
    }

    public function showPostForm()
    {
        return view('admin.post_add');
    }

    public function addPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:200',
            'description' => 'required|max:1000',
        ],
        $messages = [
            'required' => 'Поле обязательно для заполнения.',
            'max' => "Максимальная длина поля :max символов.",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        return redirect('/posts');
    }

    public function getPosts()
    {
        $objPosts = Post::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        return view('admin.user_posts')
            ->with('objPosts', $objPosts);
    }
}
