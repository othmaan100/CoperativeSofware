<?php

namespace App\Notifications;

use App\Models\Expense;

class ExpenseAwaitingAuthorizationNotification extends SimpleNotification
{
    public function __construct(protected Expense $expense) {}

    public function title(): string
    {
        return 'Expense awaiting authorization';
    }

    public function body(): string
    {
        return "{$this->expense->expense_no}: ₦".number_format((float) $this->expense->amount, 2)." for {$this->expense->description}.";
    }

    public function url(): ?string
    {
        return route('chairman.budget-approvals');
    }
}
