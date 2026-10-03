<?php

namespace App\Livewire\Announcements;

use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\NewAnnouncementNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class AnnouncementsManager extends Component
{
    use WithPagination;

    public ?int $editingId = null;

    public string $title = '';

    public string $body = '';

    public bool $is_pinned = false;

    public bool $showForm = false;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_announcements'), 403);
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'title', 'body', 'is_pinned']);
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $announcement = Announcement::findOrFail($id);
        $this->editingId = $announcement->id;
        $this->title = $announcement->title;
        $this->body = $announcement->body;
        $this->is_pinned = $announcement->is_pinned;
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'is_pinned' => ['boolean'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        if ($this->editingId) {
            $announcement = Announcement::findOrFail($this->editingId);
            $announcement->update($validated);

            ActivityLog::record('announcement.updated', "Updated announcement \"{$announcement->title}\".", $announcement);
            session()->flash('status', 'Announcement updated.');
        } else {
            $announcement = Announcement::create([
                ...$validated,
                'posted_by' => Auth::id(),
            ]);

            ActivityLog::record('announcement.posted', "Posted announcement \"{$announcement->title}\".", $announcement);

            Notification::send(User::all(), new NewAnnouncementNotification($announcement));

            session()->flash('status', 'Announcement posted and sent to every member.');
        }

        $this->closeForm();
    }

    public function delete(int $id): void
    {
        $announcement = Announcement::findOrFail($id);
        $title = $announcement->title;
        $announcement->delete();

        ActivityLog::record('announcement.deleted', "Deleted announcement \"{$title}\".");
        session()->flash('status', 'Announcement deleted.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.announcements.announcements-manager', [
            'announcements' => Announcement::with('postedBy')->orderByDesc('is_pinned')->latest()->paginate(15),
        ]);
    }
}
