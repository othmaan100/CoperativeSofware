<?php

namespace App\Notifications;

class PasswordResetByAdminNotification extends SimpleNotification
{
    public function __construct(protected bool $mustChangePassword) {}

    public function title(): string
    {
        return 'Password reset';
    }

    public function body(): string
    {
        return $this->mustChangePassword
            ? 'An administrator reset your password. You will be asked to set a new one at your next login.'
            : 'An administrator reset your password.';
    }

    public function url(): ?string
    {
        return route('profile');
    }
}
