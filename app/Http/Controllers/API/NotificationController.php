<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends ApiController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(NotificationResource::collection($notifications));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        return $this->handleResponseMessage('Notification marked as read.');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['message' => 'All notifications marked as read.']);
    }
}
