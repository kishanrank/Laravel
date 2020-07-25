<?php

namespace App\Listeners;

use App\Events\NewPostEvent;
use App\Notifications\NewPost;
use App\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
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
        $subscribers = Subscriber::all()->pluck('email')->toArray();
        Notification::route('mail', $subscribers)->notify(new NewPost($event->post));
    }
}
