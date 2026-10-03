<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\DividendPeriod;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class DividendPeriods extends Component
{
    use WithPagination;

    public bool $showCreateForm = false;

    public string $label = '';

    public string $fy_start_date = '';

    public string $fy_end_date = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_dividend_periods'), 403);
    }

    public function openCreateForm(): void
    {
        $last = DividendPeriod::query()->orderByDesc('fy_end_date')->first();

        if ($last) {
            $start = $last->fy_end_date->copy()->addDay();
        } else {
            $month = (int) Setting::get('dividend_fy_start_month', 1);
            $year = now()->month >= $month ? now()->year : now()->year - 1;
            $start = Carbon::create($year, $month, 1);
        }

        $end = $start->copy()->addYear()->subDay();

        $this->fy_start_date = $start->toDateString();
        $this->fy_end_date = $end->toDateString();
        $this->label = 'FY '.$start->format('Y').'/'.$end->format('Y');
        $this->showCreateForm = true;
    }

    public function closeCreateForm(): void
    {
        $this->showCreateForm = false;
    }

    public function createPeriod(): void
    {
        $validated = $this->validate([
            'label' => ['required', 'string', 'max:255'],
            'fy_start_date' => ['required', 'date'],
            'fy_end_date' => ['required', 'date', 'after:fy_start_date'],
        ]);

        $overlaps = DividendPeriod::query()
            ->where('fy_start_date', '<=', $validated['fy_end_date'])
            ->where('fy_end_date', '>=', $validated['fy_start_date'])
            ->exists();

        if ($overlaps) {
            $this->addError('fy_start_date', 'This date range overlaps an existing dividend period.');

            return;
        }

        $period = DividendPeriod::create([
            'label' => $validated['label'],
            'fy_start_date' => $validated['fy_start_date'],
            'fy_end_date' => $validated['fy_end_date'],
            'status' => DividendPeriod::STATUS_OPEN,
            'opened_by' => Auth::id(),
        ]);

        ActivityLog::record('dividend.period_opened', "Opened dividend period \"{$period->label}\" ({$period->fy_start_date->format('d M Y')} to {$period->fy_end_date->format('d M Y')}).", $period);

        $this->closeCreateForm();
        session()->flash('status', 'Dividend period opened. Awaiting Chairman rate declaration.');
    }

    public function calculate(int $periodId): void
    {
        abort_unless(Auth::user()->can('calculate_dividends'), 403);

        $period = DividendPeriod::findOrFail($periodId);
        $period->calculate(Auth::id());

        ActivityLog::record(
            action: 'dividend.calculated',
            description: "Calculated dividend period \"{$period->label}\" — {$period->allocations()->count()} allocation(s).",
            subject: $period,
            properties: ['total_share_dividend' => (float) $period->total_share_dividend_amount, 'total_savings_interest' => (float) $period->total_savings_interest_amount],
        );

        session()->flash('status', "Calculated {$period->allocations()->count()} member allocation(s). Review before posting.");
    }

    public function post(int $periodId): void
    {
        abort_unless(Auth::user()->can('post_dividends'), 403);

        $period = DividendPeriod::findOrFail($periodId);
        $period->post(Auth::id());

        ActivityLog::record(
            action: 'dividend.posted',
            description: "Posted dividend period \"{$period->label}\" — ₦{$period->total_share_dividend_amount} dividend, ₦{$period->total_savings_interest_amount} interest credited across {$period->allocations()->count()} member(s).",
            subject: $period,
            properties: ['total_share_dividend' => (float) $period->total_share_dividend_amount, 'total_savings_interest' => (float) $period->total_savings_interest_amount],
        );

        session()->flash('status', 'Dividend period posted. Amounts have been credited to members\' Regular Savings accounts.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.dividend-periods', [
            'periods' => DividendPeriod::query()->with(['openedBy', 'declaredBy'])->latest('fy_start_date')->paginate(15),
        ]);
    }
}
