<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
   
    public function __construct($token)
    {
        $this->token = $token;
    }

  
    public function via($notifiable)
    {
        return ['mail'];
    }
   
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Admin Password Reset Notification')
            ->line('You are receiving this email because we received a password reset request for your admin account.')
            ->action('Reset Password', url('admin/password/reset', $this->token) . '?email=' . urlencode($notifiable->getEmailForPasswordReset()))
            ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
