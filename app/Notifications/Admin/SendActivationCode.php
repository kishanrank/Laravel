<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendActivationCode extends Notification implements ShouldQueue
{
    use Queueable;

    public $url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Activate Your Admin Account')
            ->line('Welcome to our Website')
            ->line('Please verify your account by visiting this link,')
            ->line($this->url)
            ->line('If you are not able to open the link then click below button.')
            ->action('Verify Account', url($this->url))
            ->line('Thank you for using our application!');
    }
}
