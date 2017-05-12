<?php

namespace App\Events;

use App\User;
use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendToPeer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;
    private $message;
    private $recipient;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Message $message, User $recipient)
    {
         $this->user = $user;
         $this->message = $message;
         $this->recipient = $recipient;     
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('irrelevant');
    }
}
