<?php

namespace App\Notifications;

use App\Models\Announcement;

class NewAnnouncementNotification extends SimpleNotification
{
    public function __construct(protected Announcement $announcement) {}

    public function title(): string
    {
        return 'Announcement: '.$this->announcement->title;
    }

    public function body(): string
    {
        return \Illuminate\Support\Str::limit($this->announcement->body, 140);
    }

    public function url(): ?string
    {
        return route('announcements.index');
    }
}
