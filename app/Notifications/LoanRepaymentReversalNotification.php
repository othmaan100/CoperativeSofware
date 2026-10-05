<?php

namespace App\Notifications;

use App\Models\LoanRepaymentReversal;

class LoanRepaymentReversalNotification extends SimpleNotification
{
    public function __construct(public LoanRepaymentReversal $reversal) {}

    public function title(): string
    {
        return $this->reversal->status === LoanRepaymentReversal::STATUS_COMPLETED
            ? 'Excess loan repayment reversal completed'
            : 'Excess loan repayment recorded';
    }

    public function body(): string
    {
        $amount = '₦'.number_format((float) $this->reversal->amount, 2);
        $loanNo = $this->reversal->loan->loan_no;

        if ($this->reversal->status !== LoanRepaymentReversal::STATUS_COMPLETED) {
            return "{$amount} more than loan {$loanNo} owed was deducted. Choose whether to apply it to another loan or have it refunded.";
        }

        return $this->reversal->resolution === LoanRepaymentReversal::RESOLUTION_REFUND
            ? "The {$amount} excess from loan {$loanNo} has been refunded to your bank account (ref: {$this->reversal->refund_reference})."
            : "The {$amount} excess from loan {$loanNo} has been applied to loan {$this->reversal->targetLoan?->loan_no}.";
    }

    public function url(): ?string
    {
        return route('my-loans');
    }
}
