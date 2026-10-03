<?php

namespace App\Livewire\Announcements;

use App\Models\Announcement;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class AnnouncementsBoard extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.announcements.announcements-board', [
            'announcements' => Announcement::with('postedBy')->orderByDesc('is_pinned')->latest()->paginate(10),
        ]);
    }
}
