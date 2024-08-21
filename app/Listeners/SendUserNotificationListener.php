<?php

namespace App\Listeners;

use App\Events\SendUserNotification;
use App\Http\Controllers\ControllersService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserNotificationListener
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
    public function handle(SendUserNotification $event)
    {
        $user_id = $event->user_id ;
        $data = $event->data ;
        $notification_key = $event->notification_key ;
        $is_saved = $event->is_saved ;
        $type = $event->type ;
        ControllersService::NotificationToUser($user_id,$notification_key,$data,$is_saved,$type);
    }
}
