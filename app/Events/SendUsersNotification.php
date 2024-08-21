<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendUsersNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $users;
    public $data;
    public $notification_key;
    public $is_saved;
    public $is_public;
    public $image;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($users,$notification_key,$data,$is_saved=0,$is_public=0,$image=null)
    {
        $this->users = $users ;
        $this->data = $data ;
        $this->notification_key = $notification_key ;
        $this->is_saved = $is_saved ;
        $this->is_public = $is_public ;
        $this->image = $image ;
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
