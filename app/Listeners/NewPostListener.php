<?php

namespace App\Listeners;

use App\Events\NewPostEvent;
use App\Notifications\NewPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NewPostListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  NewPostEvent  $event
     * @return void
     */
    public function handle(NewPostEvent $event)
    {
        // $url = route('activate.account', ['code' => $event->user->userActivationCode->code]);
        $mail_list = ['kishanrank763@gmail.com'];
        Notification::route('mail', $mail_list)->notify(new NewPost($event->post));
    }
}
