<?php

namespace App\Notifications;

class SavingsWithdrawalDisbursedNotification extends SimpleNotification
{
    public function __construct(protected float $amount) {}

    public function title(): string
    {
        return 'Withdrawal disbursed';
    }

    public function body(): string
    {
        return 'Your withdrawal of ₦'.number_format($this->amount, 2).' has been disbursed.';
    }

    public function url(): ?string
    {
        return route('my-savings');
    }
}
