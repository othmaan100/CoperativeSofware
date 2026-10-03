<?php

namespace App\Livewire\Reports;

use App\Models\ActivityLog;
use App\Models\ApplicationFeePayment;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RegistrationFeeReports extends Component
{
    public bool $showSplitForm = false;

    public string $admin_pct = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_registration_fee_reports'), 403);
    }

    public function openSplitForm(): void
    {
        abort_unless(Auth::user()->can('manage_registration_fee_settings'), 403);

        $this->admin_pct = (string) ApplicationFeePayment::currentSplit()['admin_pct'];
        $this->showSplitForm = true;
    }

    public function closeSplitForm(): void
    {
        $this->showSplitForm = false;
    }

    public function saveSplit(): void
    {
        abort_unless(Auth::user()->can('manage_registration_fee_settings'), 403);

        $validated = $this->validate([
            'admin_pct' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $adminPct = round((float) $validated['admin_pct'], 2);
        $profitPct = round(100 - $adminPct, 2);

        Setting::set('application_fee_admin_pct', $adminPct);
        Setting::set('application_fee_profit_pct', $profitPct);

        ActivityLog::record('registration_fee.split_changed', "Updated registration fee split to {$adminPct}% admin / {$profitPct}% profit.", null, ['admin_pct' => $adminPct, 'profit_pct' => $profitPct]);

        session()->flash('status', "Split updated to {$adminPct}% admin / {$profitPct}% profit. Already-recorded payments keep the split that applied when they were paid.");
        $this->closeSplitForm();
    }

    protected function successfulPayments()
    {
        return ApplicationFeePayment::query()->where('status', ApplicationFeePayment::STATUS_SUCCESS);
    }

    protected function totals(): object
    {
        return $this->successfulPayments()
            ->selectRaw('COUNT(*) as count, SUM(amount) as total_amount, SUM(admin_amount) as total_admin, SUM(profit_amount) as total_profit')
            ->first();
    }

    protected function bySource()
    {
        return $this->successfulPayments()
            ->selectRaw('source, COUNT(*) as count, SUM(amount) as total_amount, SUM(admin_amount) as total_admin, SUM(profit_amount) as total_profit')
            ->groupBy('source')
            ->get();
    }

    /**
     * Grouped in PHP rather than SQL so this works identically across MySQL
     * (production) and SQLite (tests) without a driver-specific date
     * function — registration-fee volume is small enough that this is
     * cheap either way.
     */
    protected function byMonth()
    {
        return $this->successfulPayments()
            ->get(['amount', 'admin_amount', 'profit_amount', 'paid_at'])
            ->groupBy(fn ($payment) => $payment->paid_at->format('Y-m'))
            ->map(function ($rows, $period) {
                return (object) [
                    'period' => $period,
                    'count' => $rows->count(),
                    'total_amount' => $rows->sum('amount'),
                    'total_admin' => $rows->sum('admin_amount'),
                    'total_profit' => $rows->sum('profit_amount'),
                ];
            })
            ->sortByDesc('period')
            ->take(12)
            ->values();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.reports.registration-fee-reports', [
            'currentSplit' => ApplicationFeePayment::currentSplit(),
            'totals' => $this->totals(),
            'bySource' => $this->bySource(),
            'byMonth' => $this->byMonth(),
            'recentPayments' => $this->successfulPayments()->with(['member', 'recordedBy'])->latest('paid_at')->limit(25)->get(),
        ]);
    }
}
