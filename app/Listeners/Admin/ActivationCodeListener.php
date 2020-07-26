<?php

namespace App\Listeners\Admin;

use App\Events\Admin\ActivationCodeEvent;
use App\Notifications\Admin\SendActivationCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ActivationCodeListener
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
     * @param  ActivationCodeEvent  $event
     * @return void
     */
    public function handle(ActivationCodeEvent $event)
    {
        $url = route('admin.activate.account', ['code' => $event->admin->adminActivationCode->code]);
        Notification::send($event->admin, new SendActivationCode($url));
    }
}
