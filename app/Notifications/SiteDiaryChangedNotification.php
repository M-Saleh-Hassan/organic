<?php

namespace App\Notifications;

use App\Models\SiteDiary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SiteDiaryChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public SiteDiary $siteDiary,
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
            ->subject('Site Diary Has Been Changed')
            ->greeting('Hello ' . $notifiable->first_name)
            ->line($this->siteDiary->name . ' has been changed.')
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
            'icon'       => $this->siteDiary->user->profile_image,
            'type'       => 'sitediary_changed',
            'model'      => $this->siteDiary->id,
            'model_type' => SiteDiary::class,
            'changes'    => $this->siteDiary->getChanges(),
        ];
    }
}
