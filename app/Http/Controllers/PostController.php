<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePostRequest;

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
     * @param  StorePostRequest  $request
     * @return bool|RedirectResponse
     */
    public function store(StorePostRequest $request): bool|RedirectResponse
    {
        if ($request->user()->can('create', Post::class)) {
            $request['user_id'] = $request->user()->id;
            Post::create($request->all());
            $request->session()->flash('post_add', 'Пост успешно создан!');
            return redirect()->route('all_user_posts');
        } else {
            abort(403);
            return false;
        }
    }

    /**
     * @return View
     */
    public function getPostsOrderByDateDesc(): View
    {
        $objPosts = Post::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        return view('admin.user_posts')
            ->with('objPosts', $objPosts);
    }

    /**
     * @param  Post  $post
     * @return View|bool
     */
    public function edit(Post $post): View|bool
    {
        if (Auth::user()->can('update', $post)) {
            return view('posts.edit')
                ->with('objPost', $post);
        } else {
            abort(403);
            return false;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostRequest  $request
     * @param  Post  $post
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();
        $request->session()->flash('post_edited', 'Пост успешно иßзменен!');
        return redirect()->route('all_user_posts');
    }

    public function destroy(Post $post, Request $request)
    {
        dd('asdsad');
        $post->delete();
        echo 'success';
        $request->session()->flash('post_edited', 'Пост успешно удален!');
        $this->getPostsOrderByDateDesc();
    }
}
