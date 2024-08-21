<?php

namespace App\Listeners;

use App\Events\SendSilentUserNotification;
use App\Http\Controllers\ControllersService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSilentUserNotificationListener
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
     * @param  SendSilentUserNotification  $event
     * @return void
     */
    public function handle(SendSilentUserNotification $event)
    {
        $user_id = $event->user_id ;
        $data = $event->data ;
        $action = $event->action ;
        $type = $event->type ;
        ControllersService::NotificationToUserSilent($user_id,$data,$action,$type);
    }
}
