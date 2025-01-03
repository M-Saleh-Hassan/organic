<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ReportFailedNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationFailed $event): void
    {
        Log::error('Notification failed', [
            'event' => $event,
        ]);

    }
}
