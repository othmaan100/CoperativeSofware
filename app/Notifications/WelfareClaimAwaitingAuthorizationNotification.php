<?php

namespace App\Notifications;

use App\Models\WelfareClaim;

class WelfareClaimAwaitingAuthorizationNotification extends SimpleNotification
{
    public function __construct(protected WelfareClaim $claim) {}

    public function title(): string
    {
        return 'Welfare claim awaiting authorization';
    }

    public function body(): string
    {
        return "{$this->claim->claim_no}: ₦".number_format((float) $this->claim->amount, 2)." death benefit for {$this->claim->member->full_name}.";
    }

    public function url(): ?string
    {
        return route('welfare.claims.show', $this->claim);
    }
}
