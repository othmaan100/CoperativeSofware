<?php

namespace App\Notifications;

class DividendPostedNotification extends SimpleNotification
{
    public function __construct(
        protected string $periodLabel,
        protected float $dividendAmount,
        protected float $interestAmount,
    ) {}

    public function title(): string
    {
        return 'Dividend credited';
    }

    public function body(): string
    {
        $parts = [];

        if ($this->dividendAmount > 0) {
            $parts[] = '₦'.number_format($this->dividendAmount, 2).' dividend';
        }

        if ($this->interestAmount > 0) {
            $parts[] = '₦'.number_format($this->interestAmount, 2).' interest';
        }

        return implode(' and ', $parts)." credited to your Savings account for {$this->periodLabel}.";
    }

    public function url(): ?string
    {
        return route('my-dividends');
    }
}
