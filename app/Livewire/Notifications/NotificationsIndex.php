<?php

namespace App\Livewire\Notifications;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsIndex extends Component
{
    use WithPagination;

    public function markAsRead(string $notificationId): void
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        $this->dispatch('notifications-changed');
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('notifications-changed');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.notifications.notifications-index', [
            'notifications' => Auth::user()->notifications()->paginate(20),
        ]);
    }
}
