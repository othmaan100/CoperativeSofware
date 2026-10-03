<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Failed;

class LogFailedLogin
{
    /**
     * Never log the raw credentials array — it carries the attempted
     * plaintext password. Only the identifier (email) is safe to record.
     */
    public function handle(Failed $event): void
    {
        $identifier = $event->credentials['email'] ?? null;

        ActivityLog::record(
            action: 'auth.login_failed',
            description: $identifier ? "Failed login attempt for {$identifier}." : 'Failed login attempt.',
            subject: $event->user,
            properties: $identifier ? ['attempted_email' => $identifier] : [],
        );
    }
}
