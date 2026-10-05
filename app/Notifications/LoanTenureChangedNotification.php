<?php

namespace App\Notifications;

use App\Models\LoanTenureChangeRequest;

class LoanTenureChangedNotification extends SimpleNotification
{
    public function __construct(public LoanTenureChangeRequest $request) {}

    public function title(): string
    {
        return 'Loan tenure extended';
    }

    public function body(): string
    {
        $loanNo = $this->request->loan->loan_no;
        $installment = '₦'.number_format((float) $this->request->applied_installment, 2);

        return "The tenure of loan {$loanNo} has been extended to {$this->request->requested_tenure_months} months. Your monthly repayment is now {$installment}.";
    }

    public function url(): ?string
    {
        return route('my-loans');
    }
}
