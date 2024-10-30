<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class UserCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public $token,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
        // FCMChannel::class
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $baseUrl = config('mail.reset_password_url');
        $queryParams = [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ];

        $resetUrl = $baseUrl . '?' . http_build_query($queryParams);
        return (new MailMessage)
            ->subject('Verification Email')
            ->greeting('Hello ' . $notifiable->first_name)
            ->line('You are invited to join RXA.')
            ->line(request()->has('invite_message') ? request('invite_message'): 'You can check it here!')
            ->action('Login', $resetUrl);
    }

    /**
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
