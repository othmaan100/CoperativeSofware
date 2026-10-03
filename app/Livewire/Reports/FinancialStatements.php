<?php

namespace App\Livewire\Reports;

use App\Services\FinancialStatementService;
use App\Support\FinancialYear;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class FinancialStatements extends Component
{
    public int $startYear;

    public string $tab = 'trial_balance';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_financial_statements'), 403);
        [$this->startYear] = FinancialYear::current();
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $service = new FinancialStatementService;
        [$start, $end] = FinancialYear::boundsFor($this->startYear);

        return view('livewire.reports.financial-statements', [
            'label' => FinancialYear::labelFor($this->startYear),
            'availableYears' => FinancialYear::availableStartYears(),
            'trialBalance' => $service->trialBalance($start, $end),
            'incomeStatement' => $service->incomeStatement($start, $end),
            'balanceSheet' => $service->balanceSheet($end),
        ]);
    }
}
