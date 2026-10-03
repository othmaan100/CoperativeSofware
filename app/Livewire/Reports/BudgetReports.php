<?php

namespace App\Livewire\Reports;

use App\Models\Budget;
use App\Models\Expense;
use App\Support\FinancialYear;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BudgetReports extends Component
{
    public int $startYear;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_budget_reports'), 403);
        [$this->startYear] = FinancialYear::current();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $budget = Budget::query()->with('lines')->where('fy_start_year', $this->startYear)->first();

        $expenses = $budget
            ? Expense::query()->whereIn('budget_line_id', $budget->lines->pluck('id'))->with('budgetLine')->latest()->get()
            : collect();

        $availableYears = array_values(array_unique(array_merge(
            FinancialYear::availableStartYears(),
            Budget::query()->pluck('fy_start_year')->all()
        )));
        rsort($availableYears);

        return view('livewire.reports.budget-reports', [
            'label' => FinancialYear::labelFor($this->startYear),
            'availableYears' => $availableYears,
            'budget' => $budget,
            'expenses' => $expenses,
        ]);
    }
}
