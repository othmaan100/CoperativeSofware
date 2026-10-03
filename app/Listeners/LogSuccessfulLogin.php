<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        ActivityLog::record(
            action: 'auth.login',
            description: "{$event->user->name} logged in.",
            subject: $event->user,
            causerId: $event->user->id,
        );
    }
}
