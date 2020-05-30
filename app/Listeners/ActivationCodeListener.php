<?php

namespace App\Listeners;

use App\Events\ActivationCodeEvent;
use App\Notifications\AccountActivation;
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
        $url = route('activate.account', ['code' => $event->user->userActivationCode->code]);
        Notification::send($event->user, new AccountActivation($url));
    }
}
