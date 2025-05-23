<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Soap\Url;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token; // Added to store the token

    /**
     * Create a new notification instance.
     */
    public function __construct($token)  #modifying the constructor to accept token
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]));

        return (new MailMessage)
            ->subject('AXIA HUB - Password Reset Request')
            ->markdown('vendor.mail.html.custom_reset', [
                'logo' => Url('storage/images/axialogo.jpg'),
                'name' => $notifiable->name,
                'resetUrl' => $resetUrl
            ]);
                    // ->subject('AXIA HUB - Password Reset Request')
                    // ->greeting('Hello ' . $notifiable->name . '!')
                    // ->line('You requested a password reset for your AXIA HUB account. Please click the link below to reset your password.')
                    // ->action('Reset Password', $resetUrl)
                    // ->line('This link expires in 60 minutes.')
                    // ->line("If you didn't request this, please ignore this email.")
                    // ->salutation('Regards, AXIA HUB Team.');

    }

    /*
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
