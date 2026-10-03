<?php

namespace App\Notifications;

use App\Models\WelfareClaim;

class WelfareClaimAuthorizationDecisionNotification extends SimpleNotification
{
    public function __construct(protected WelfareClaim $claim, protected bool $authorized) {}

    public function title(): string
    {
        return $this->authorized ? 'Welfare claim authorized' : 'Welfare claim declined';
    }

    public function body(): string
    {
        $verb = $this->authorized ? 'authorized' : 'declined';

        return "{$this->claim->claim_no} ({$this->claim->member->full_name}) was {$verb} by the Chairman.";
    }

    public function url(): ?string
    {
        return route('welfare.claims.show', $this->claim);
    }
}
