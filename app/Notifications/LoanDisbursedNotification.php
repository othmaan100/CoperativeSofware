<?php

namespace App\Notifications;

use App\Models\Loan;

class LoanDisbursedNotification extends SimpleNotification
{
    public function __construct(protected Loan $loan) {}

    public function title(): string
    {
        return 'Loan disbursed';
    }

    public function body(): string
    {
        return "Your loan {$this->loan->loan_no} of ₦".number_format((float) $this->loan->principal_amount, 2).' has been disbursed.';
    }

    public function url(): ?string
    {
        return route('loans.show', $this->loan);
    }
}
