<?php

namespace App\Notifications;

use App\Models\Expense;

class ExpenseAuthorizationDecisionNotification extends SimpleNotification
{
    public function __construct(protected Expense $expense, protected bool $authorized) {}

    public function title(): string
    {
        return $this->authorized ? 'Expense authorized' : 'Expense declined';
    }

    public function body(): string
    {
        $verb = $this->authorized ? 'authorized' : 'declined';

        return "{$this->expense->expense_no} ({$this->expense->description}) was {$verb} by the Chairman.";
    }

    public function url(): ?string
    {
        return route('treasurer.budget-manager');
    }
}
