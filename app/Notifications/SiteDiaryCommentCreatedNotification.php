<?php

namespace App\Notifications;

use App\Models\SiteDiaryComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SiteDiaryCommentCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public SiteDiaryComment $siteDiaryComment,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Site Diary Comment')
            ->greeting('Hello ' . $notifiable->first_name)
            ->line('A new site diary comment has been created.')
            ->line('You can check it here!')
            ->action('Dashboard', config('mail.frontend_url'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'icon'       => $notifiable->profile_image,
            'type'       => 'sitediary_comment_created',
            'model'      => $this->siteDiaryComment->id,
            'model_type' => SiteDiaryComment::class,
        ];
    }
}
