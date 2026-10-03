<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

/**
 * Shared shape for every in-app notification in this system: a title, a
 * body, and an optional link to follow. Keeping every notification's stored
 * `data` in this same {title, body, url} shape is what lets the bell/inbox
 * UI render any notification type generically, without per-type Blade
 * branches — new notification types slot in without touching the UI.
 */
abstract class SimpleNotification extends Notification
{
    abstract public function title(): string;

    abstract public function body(): string;

    public function url(): ?string
    {
        return null;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title(),
            'body' => $this->body(),
            'url' => $this->url(),
        ];
    }
}
