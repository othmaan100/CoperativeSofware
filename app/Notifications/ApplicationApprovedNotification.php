<?php

namespace App\Notifications;

class ApplicationApprovedNotification extends SimpleNotification
{
    public function __construct(protected string $membershipNo) {}

    public function title(): string
    {
        return 'Application approved';
    }

    public function body(): string
    {
        return "Your membership application has been approved. Membership No: {$this->membershipNo}.";
    }

    public function url(): ?string
    {
        return route('my-application');
    }
}
