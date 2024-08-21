<?php

namespace App\Providers;

use App\Events\SendAdminNotification;
use App\Events\SendDriversNotification;
use App\Events\SendSilentUserNotification;
use App\Events\SendSMS;
use App\Events\SendUserEmail;
use App\Events\SendUserNotification;
use App\Events\SendUsersNotification;
use App\Listeners\SendAdminNotificationListener;
use App\Listeners\SendDriversNotificationListener;
use App\Listeners\SendSilentUserNotificationListener;
use App\Listeners\SendSMSListener;
use App\Listeners\SendUserEmailListener;
use App\Listeners\SendUserNotificationListener;
use App\Listeners\SendUsersNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SendUserNotification::class => [
            SendUserNotificationListener::class,
        ],
        SendAdminNotification::class => [
            SendAdminNotificationListener::class,
        ],
        SendSilentUserNotification::class => [
            SendSilentUserNotificationListener::class,
        ],
        SendSMS::class => [
            SendSMSListener::class,
        ],
        SendUserEmail::class => [
            SendUserEmailListener::class,
        ],
        SendUsersNotification::class => [
            SendUsersNotificationListener::class,
        ],
        SendDriversNotification::class => [
            SendDriversNotificationListener::class,
        ],

    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
