<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCommentRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreCommentRequest $request): RedirectResponse
    {
        $comment = new Comment(['user_id' => Auth::id(), 'text' => $request->comment]);

        if ($request->has('comment_id')) {
            $parent = Comment::find($request->comment_id);
        } else {
            $parent = Post::find($request->post_id);
        }

        $result = $parent->comments()->save($comment);
        $request->session()->flash('comment_add', 'Комментарий добавлен!');
        if ('App\\Models\\Comment' === $result->commentable_type) {
            $request->session()->flash('post_id', $parent->commentable->id);
            $request->session()->flash('comment_id', $parent->id);
            $request->session()->flash('subcomment_id', $result->id);
        } else {
            $request->session()->flash('post_id', $parent->id);
            $request->session()->flash('comment_id', $result->id);
        }
        return redirect($request->url());
    }

    /**
     * Display the specified resource.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment  $comment
     * @return RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();
        session()->flash('comment_deleted', 'Комментарий удален!');
        return redirect()->back();
    }
}
