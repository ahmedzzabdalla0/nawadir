<?php

namespace App\Listeners;

use App\Events\SendDriversNotification;
use App\Events\SendUserNotification;
use App\Events\SendUsersNotification;
use App\Http\Controllers\ControllersService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDriversNotificationListener
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
     * @param  SendDriversNotification  $event
     * @return void
     */
    public function handle(SendDriversNotification $event)
    {
        $users = $event->users ;
        $data = $event->data ;
        $notification_key = $event->notification_key ;
        $is_saved = $event->is_saved ;
        $is_public = $event->is_public ;
        $image = $event->image ;
            foreach($users as $usr){
                event(new SendUserNotification($usr->id,  $notification_key,  $data,$is_saved,'driver'));
            }


    }
}
