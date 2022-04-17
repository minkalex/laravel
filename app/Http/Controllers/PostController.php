<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
        $objUser = User::find($userId);
        $objComments = collect([]);
        if (Auth::check()) {
            $objPosts = Post::where('user_id', $userId)->with('comments')->orderByDesc('created_at')->get();
            foreach ($objPosts as $objPost) {
                $objPost->comments->sortByDesc('created_at');
                foreach ($objPost->comments as $objComment) {
                    $comments = Comment::find($objComment->id)->comments->sortByDesc('created_at');
                    if ($comments->isNotEmpty()) {
                        $objComments->push([$objComment->id => $comments]);
                    }
                }
            }
        } else {
            $objPosts = $objUser->posts->sortByDesc('created_at');
        }
        return view('posts')
            ->with('user', $objUser->full_name)
            ->with('objPosts', $objPosts)
            ->with('objComments', $objComments);
    }

    /**
     * View for index page
     *
     * @return View
     */
    public function index(): View
    {
        $objUsers = User::has('posts')
            ->orderBy('last_name')
            ->orderBy('name')
            ->get();
        return view('authors')->with('objUsers', $objUsers);
    }

    /**
     * @return View
     */
    public function showPostForm(): View
    {
        return view('admin.post_add');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function addPost(Request $request): RedirectResponse
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
        $request->session()->flash('post_add', 'Пост успешно создан!');
        return redirect()->route('all_user_posts');
    }

    public function getPostsOrderByDateDesc()
    {
        $objPosts = Post::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        return view('admin.user_posts')
            ->with('objPosts', $objPosts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:200',
        ],
            $messages = [
                'required' => 'Поле обязательно для заполнения.',
                'max' => "Максимальная длина поля :max символов.",
            ]);

        if ($validator->fails()) {
            $request->session()->flash('comment_error', 'Комментарий не был добавлен!');
            return redirect($request->url())
                ->withErrors($validator)
                ->withInput();
        }

        Comment::create([
            'user_id' => Auth::id(),
            'text' => $request->comment,
            'commentable_id' => $request->post_id,
            'commentable_type' => 'App\Models\Post',
        ]);
        $request->session()->flash('comment_add', 'Комментарий успешно добавлен!');
        return redirect($request->url());
    }
}
