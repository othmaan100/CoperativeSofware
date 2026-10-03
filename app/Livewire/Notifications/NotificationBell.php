<?php

namespace App\Livewire\Notifications;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationBell extends Component
{
    public bool $open = false;

    #[On('notifications-changed')]
    public function refresh(): void
    {
        // No-op — merely re-renders the component when the event fires
        // (e.g. after markAllAsRead on the full notifications page).
    }

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        $user = Auth::user();

        return view('livewire.notifications.notification-bell', [
            'unreadCount' => $user->unreadNotifications()->count(),
            'recent' => $user->notifications()->latest()->limit(8)->get(),
        ]);
    }
}
