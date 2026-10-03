<?php

namespace App\Livewire\Announcements;

use App\Models\Announcement;
use Livewire\Component;

class AnnouncementsWidget extends Component
{
    public function render()
    {
        return view('livewire.announcements.announcements-widget', [
            'announcements' => Announcement::orderByDesc('is_pinned')->latest()->limit(3)->get(),
        ]);
    }
}
