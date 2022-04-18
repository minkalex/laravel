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

    /**
     * @return View
     */
    public function getPostsOrderByDateDesc(): View
    {
        $objPosts = Post::where('user_id', Auth::id())->orderByDesc('created_at')->get();
        return view('admin.user_posts')
            ->with('objPosts', $objPosts);
    }

    public function showEditForm()
    {
        $arUrl = explode("/", url()->current());
        //post_id from url
        $objPost = Post::find($arUrl[6]);
        return view('posts.edit')
            ->with('objPost', $objPost);
    }

    public function edit(Post $post, Request $request)
    {
        dd('123213213');
        $arUrl = explode("/", url()->current());
        //post_id from url
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:200',
            'description' => 'required|max:1000',
        ]);
        if ($validator->fails()) {
            echo 'error';
            $request->session()->flash('post_error', 'Пост не изменен!');
        } else {
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();
            echo 'success';
            $request->session()->flash('post_edited', 'Пост успешно изменен!');
        }
        $this->getPostsOrderByDateDesc();
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
