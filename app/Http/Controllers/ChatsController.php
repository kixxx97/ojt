<?php

namespace App\Http\Controllers;

use App\Message;
use App\Room;
use App\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendMessage;

<!--  -->lass ChatsController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show chats
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages(Request $request)
    {
        if(Auth::user()->roles == 'agent')
        {    
            return Message::where('user_id',Auth::user()->id)->where('room_id', null)->orWhere('recipient_id',Auth::user()->id)->with('user')->get();
        }
        else
        {
            $user = $request->input('user_id');
            return Message::where('user_id',$user)->where('room_id',null)->orWhere('recipient_id',$user)->with('user')->get();
        }
    }

    public function fetchPrivateMessages(Request $request)
    {
        return Message::where('room_id', $request->input('room'))->with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {   
        $user = Auth::user();
        // dd($request->input());
        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'room_id' => $request->input('room'),
            'recipient_id' => $request->input('recipient')
        ]);
        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }

    public function peerChat(Request $request)//room_id is shown here and id sa IT
    {
        if(Auth::user()->roles == 'agent')
        {
        $recipient = User::where('roles','IT')->firstOrFail();
        $room = Room::where('member1',Auth::user()->id)->where('member2',$recipient->id)->firstOrFail();
        $recipient = Auth::user();
        }
        else
        {
        $recipient = User::find(1);
        $room = Room::where('member1',$recipient->id)->where('member2',Auth::user()->id)->firstOrFail();
        }
        return view('peerChat',compact('recipient','room'));
    }

    public function sendMail()
    {
        \Mail::to('test@example.com')->send(new SendMessage);
    }
}
