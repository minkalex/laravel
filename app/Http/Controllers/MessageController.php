<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return
     */
    public function index(Request $request)
    {
        if ($request->hasHeader('X-Requested-With')) {
            $arrMessages = Chat::find($request->chat_id)->messages;
            $arrUsers = User::all();
            foreach ($arrMessages as $index => $arrMessage) {
                foreach ($arrUsers as $arrUser) {
                    if ($arrUser->id === $arrMessage->user_id) {
                        $arrMessages[$index]['user_fullname'] = $arrUser->full_name;
                    }
                }
                $arrMessages[$index]['formatted_date'] = date('d.m.Y H:i', strtotime($arrMessage['created_at']));
            }
            return $arrMessages;
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
     * @param  StoreMessageRequest  $request
     * @return void
     */
    public function store(StoreMessageRequest $request): void
    {
        Message::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
