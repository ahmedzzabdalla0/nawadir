<?php

namespace App\Listeners;

use App\Events\SendUserEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserEmailListener
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
     * @param  SendUserEmail  $event
     * @return void
     */
    public function handle(SendUserEmail $event)
    {
        $object = $event->object;
        $mail = $event->mail;
        try {
            \Mail::to($object)->send($mail);
        } catch (\Exception $e) {

        }
    }
}
