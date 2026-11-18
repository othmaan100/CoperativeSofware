<?php

namespace App\Livewire\Chairman;

use App\Models\ActivityLog;
use App\Models\DividendPeriod;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DividendDeclarations extends Component
{
    public ?int $activePeriodId = null;

    public string $share_dividend_rate_pct = '';

    public string $savings_interest_rate_pct = '';

    public string $fy_start_month = '';

    /** Sum of all active members' average share / savings balances for the period being declared. */
    public float $avgShareTotal = 0.0;

    public float $avgSavingsTotal = 0.0;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('declare_dividend_rates'), 403);
        $this->fy_start_month = (string) Setting::get('dividend_fy_start_month', 1);
    }

    public function saveFyStartMonth(): void
    {
        $validated = $this->validate([
            'fy_start_month' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        Setting::set('dividend_fy_start_month', (int) $validated['fy_start_month']);
        ActivityLog::record('dividend.fy_start_month_changed', "Set dividend financial year start month to {$validated['fy_start_month']}.", null, $validated);
        session()->flash('status', 'Financial year start month updated. This only affects periods opened from now on.');
    }

    public function openDeclareForm(int $periodId): void
    {
        $period = DividendPeriod::findOrFail($periodId);

        $this->activePeriodId = $periodId;
        $this->share_dividend_rate_pct = '';
        $this->savings_interest_rate_pct = '';

        // Worked out once here (it walks every member's ledger); the live
        // preview then only multiplies these by the rates being typed.
        ['share' => $this->avgShareTotal, 'savings' => $this->avgSavingsTotal] = $period->averageBalanceTotals();
    }

    /**
     * Estimated payout at the rates currently typed in, against the
     * period's distributable profit.
     *
     * @return array{share: float, savings: float, total: float, profit: float, over: bool, shortfall: float}
     */
    protected function payoutPreview(float $profit): array
    {
        $shareRate = is_numeric($this->share_dividend_rate_pct) ? (float) $this->share_dividend_rate_pct : 0.0;
        $savingsRate = is_numeric($this->savings_interest_rate_pct) ? (float) $this->savings_interest_rate_pct : 0.0;

        $share = round($this->avgShareTotal * $shareRate / 100, 2);
        $savings = round($this->avgSavingsTotal * $savingsRate / 100, 2);
        $total = round($share + $savings, 2);

        return [
            'share' => $share,
            'savings' => $savings,
            'total' => $total,
            'profit' => $profit,
            'over' => $total > $profit,
            'shortfall' => round(max(0, $total - $profit), 2),
        ];
    }

    public function closeModal(): void
    {
        $this->activePeriodId = null;
    }

    public function saveDeclare(): void
    {
        $period = DividendPeriod::findOrFail($this->activePeriodId);
        abort_unless($period->status === DividendPeriod::STATUS_OPEN, 400, 'Rates can only be declared for an open period.');

        $validated = $this->validate([
            'share_dividend_rate_pct' => ['required', 'numeric', 'min:0', 'max:100'],
            'savings_interest_rate_pct' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $snapshot = $period->distributableProfit(); // system-tracked + legacy entries

        $period->update([
            'share_dividend_rate_pct' => $validated['share_dividend_rate_pct'],
            'savings_interest_rate_pct' => $validated['savings_interest_rate_pct'],
            'distributable_profit_snapshot' => $snapshot,
            'status' => DividendPeriod::STATUS_DECLARED,
            'declared_by' => Auth::id(),
            'declared_at' => now(),
        ]);

        ActivityLog::record(
            action: 'dividend.rates_declared',
            description: "Declared rates for \"{$period->label}\": {$validated['share_dividend_rate_pct']}% dividend, {$validated['savings_interest_rate_pct']}% interest.",
            subject: $period,
            properties: $validated,
        );

        $this->closeModal();
        session()->flash('status', 'Rates declared. Sent to the Treasurer for calculation.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $activePeriod = $this->activePeriodId ? DividendPeriod::find($this->activePeriodId) : null;
        $profitBreakdown = $activePeriod?->profitBreakdown();
        $distributableEstimate = $profitBreakdown['total'] ?? null;

        return view('livewire.chairman.dividend-declarations', [
            'periods' => DividendPeriod::query()->latest('fy_start_date')->paginate(15),
            'activePeriod' => $activePeriod,
            'profitBreakdown' => $profitBreakdown,
            'legacyProfits' => $activePeriod ? $activePeriod->legacyProfits()->orderBy('id')->get() : collect(),
            'distributableEstimate' => $distributableEstimate,
            'preview' => $activePeriod ? $this->payoutPreview((float) $distributableEstimate) : null,
        ]);
    }
}
