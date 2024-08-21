<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendAdminNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $channel;
    public $OBdata;
    public $OBevent;


    /**
     * Create a new event instance.
     *
     * @param $channel
     * @param $event
     * @param $OBdata
     */
    public function __construct($channel,$OBevent,$OBdata)
    {
        $this->channel = $channel ;
        $this->OBevent = $OBevent ;
        $this->OBdata = $OBdata ;
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
