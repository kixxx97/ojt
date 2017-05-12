<?php

namespace App\Http\Controllers;

use App\Message;
use App\Room;
use App\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
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
        if($request->input('id'))
        {
            $recipient = json_decode($request->input('id'));
            $id = $recipient['id'];
            return Message::where('room_id', $request->input('room_id'))->with('sender')->with('user')->get(); 
        }
        else{
            return Message::where('user_id',Auth::user()->id)->where('room_id', null)->orWhere('recipient_id',Auth::user()->id)->with('user')->get();
            //all messages coming from him  and for him and that null ang room id
        }
        }
        else
        {
            if($request->input('id'))
            {

            }
            else{
            return Message::where('user_id','1')->orWhere('recipient_id','1')->where('room_id',null)->with('user')->get();
            // all messages for agent
            }
        }
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
        
        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'room_id' => $request->input('room_id'),
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
        }
        else
        {
        $recipient = User::find(1);
        $room = Room::where('member1',$recipient->id)->where('member2',Auth::user()->id)->firstOrFail();
        }
        return view('peerChat',compact('recipient','room'));
    }
}
