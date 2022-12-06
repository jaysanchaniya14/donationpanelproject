<?php

namespace App\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token, $for_app;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $for_app = false)
    {
        $this->token = $token;
        $this->for_app = $for_app;
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
        if($this->for_app){
            $url = route('reset-password', ['token' => $this->token]).'?token='.$this->token.'&created='.time();

            $controller = new Controller();
            $link = $controller->generate_short_link($url);
            $link = $link ?? $url;
        }
        else{
            $link = route('reset-password', ['token' => $this->token]);
        }

        return (new MailMessage)
        ->subject(__('Reset Password'))
        ->line(__('You are receiving this email because we received a password reset request for your account.'))
        ->action(__('Reset Password'), $link)
        ->line(__('This link is valid for 10 minutes only.'))
        ->line(__('If you did not request a password reset, no further action is required.'));
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
