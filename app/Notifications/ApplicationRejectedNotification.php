<?php

namespace App\Notifications;

class ApplicationRejectedNotification extends SimpleNotification
{
    public function __construct(protected string $reason) {}

    public function title(): string
    {
        return 'Application rejected';
    }

    public function body(): string
    {
        return "Your membership application was not approved. Reason: {$this->reason}";
    }

    public function url(): ?string
    {
        return route('my-application');
    }
}
