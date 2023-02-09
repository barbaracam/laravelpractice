<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
//1.below line added and implement after the class in line 16
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

//2.we go after addign this to --construct function
class ChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // 4. add this line, make sure construct function is accesing the values from $chat  
    public $chat;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chat)
    {
        // 3.
        $this->chat =['username' =>$chat['username'], 'avatar'=>$chat['avatar'], 'textvalue'=>$chat['textvalue']];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {   //5. change name of the privateChannell(blabla), then go to channels.php
        //can be make a private channel too instead
        return new PrivateChannel('chatchannel');
    }
}
