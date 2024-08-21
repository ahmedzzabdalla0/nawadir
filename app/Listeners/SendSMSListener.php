<?php

namespace App\Listeners;

use App\Events\SendSMS;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSMSListener
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
     * @param  SendSMS  $event
     * @return void
     */
    public function handle(SendSMS $event)
    {
         $mobile = $event->mobile;
         $message = $event->message;
        \HELPER::send_sms($mobile, $message);
    }
}
