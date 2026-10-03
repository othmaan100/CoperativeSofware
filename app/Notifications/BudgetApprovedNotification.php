<?php

namespace App\Notifications;

use App\Models\Budget;
use App\Support\FinancialYear;

class BudgetApprovedNotification extends SimpleNotification
{
    public function __construct(protected Budget $budget) {}

    public function title(): string
    {
        return 'Budget approved';
    }

    public function body(): string
    {
        $label = FinancialYear::labelFor($this->budget->fy_start_year);

        return "The {$label} budget (₦".number_format($this->budget->totalBudgeted(), 2).') has been approved by the Chairman.';
    }

    public function url(): ?string
    {
        return route('treasurer.budget-manager');
    }
}
