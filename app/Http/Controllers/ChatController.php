<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     */
    public function index(Request $request)
    {
        if ($request->hasHeader('X-Requested-With')) {
            return Auth::user()->chats()->with('users')->get();
        } else {
            $chats = Auth::user()->chats;
            $users = User::all();
            return view('chat')
                ->with(compact('chats', 'users'));
        }
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
     * @param  StoreChatRequest  $request
     * @return void
     */
    public function store(StoreChatRequest $request): void
    {
        if (empty($request->title)) {
            if (count($request->usersId) > 1) {
                $lastChatId = Chat::all()->last()->id;
                $request['title'] = 'chat #'.$lastChatId + 1;
            }
        }
        $result = Chat::create($request->except(['usersId']));
        $arData = [];
        foreach ($request->usersId as $userId) {
            $arData[] = [
                'user_id' => $userId,
                'chat_id' => $result['id'],
                'created_at' => date('c'),
                'updated_at' => date('c')
            ];
        }
        $arData[] = [
            'user_id' => $request->created_by,
            'chat_id' => $result['id'],
            'created_at' => date('c'),
            'updated_at' => date('c')
        ];
        DB::table('chat_user')->insert($arData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChatRequest  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }

    /**
     *
     * @param  Request  $request
     * @param  Chat  $chat
     */
    public function getParticipants(Request $request, Chat $chat)
    {
        if ($request->hasHeader('X-Requested-With')) {
            return $chat->users;
        }
        return [];
    }
}
