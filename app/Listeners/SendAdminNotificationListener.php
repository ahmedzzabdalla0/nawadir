<?php

namespace App\Listeners;

use App\Events\SendAdminNotification;
use App\Events\SendUserNotification;
use App\Http\Controllers\ControllersService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdminNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendUserNotification  $event
     * @return void
     */
    public function handle(SendAdminNotification $event)
    {
        $channel = $event->channel ;
        $event2 = $event->OBevent ;
        $data = $event->OBdata ;
        ControllersService::NotificationToAdmin($channel, $event2,$data);
    }
}
