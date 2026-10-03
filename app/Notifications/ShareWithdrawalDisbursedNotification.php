<?php

namespace App\Notifications;

class ShareWithdrawalDisbursedNotification extends SimpleNotification
{
    public function __construct(protected int $shares) {}

    public function title(): string
    {
        return 'Share withdrawal disbursed';
    }

    public function body(): string
    {
        return "Your withdrawal of {$this->shares} share(s) has been disbursed.";
    }

    public function url(): ?string
    {
        return route('my-shares');
    }
}
