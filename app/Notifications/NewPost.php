<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPost extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $post;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
        $this->title = $post->title;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // return (new MailMessage)->
        // markdown('admin.notification.newpost', ['title' => $this->title, 'url' => "www.google.com"]);

        return (new MailMessage)
            ->subject('Hey user, New post availabe')
            ->greeting('Hello', 'Subscriber')
            ->line('There is a new post , hope you will like it')
            ->line('Post title : ' . $this->title) //Send with post title
            ->action('Read Post', url(route('post.single', ['slug' => $this->post->slug]))) //Send with post url
            ->line('Thank you for being with us!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
