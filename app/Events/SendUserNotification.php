<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendUserNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_id;
    public $data;
    public $notification_key;
    public $is_saved;
    public $type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id,$notification_key,$data,$is_saved=0,$type='user')
    {
        $this->user_id = $user_id ;
        $this->data = $data ;
        $this->notification_key = $notification_key ;
        $this->is_saved = $is_saved ;
        $this->type = $type ;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('channel-name');
//    }
}
