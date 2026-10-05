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
    public bool $showSettingsForm = false;

    public string $fee_amount = '';

    public string $admin_pct = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_registration_fee_reports'), 403);
    }

    public function openSettingsForm(): void
    {
        abort_unless(Auth::user()->can('manage_registration_fee_settings'), 403);

        $this->fee_amount = (string) ApplicationFeePayment::currentFee();
        $this->admin_pct = (string) ApplicationFeePayment::currentSplit()['admin_pct'];
        $this->resetErrorBag();
        $this->showSettingsForm = true;
    }

    public function closeSettingsForm(): void
    {
        $this->showSettingsForm = false;
    }

    public function saveSettings(): void
    {
        abort_unless(Auth::user()->can('manage_registration_fee_settings'), 403);

        $validated = $this->validate([
            'fee_amount' => ['required', 'numeric', 'min:1', 'max:10000000'],
            'admin_pct' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $oldFee = ApplicationFeePayment::currentFee();
        $oldSplit = ApplicationFeePayment::currentSplit();

        $fee = round((float) $validated['fee_amount'], 2);
        $adminPct = round((float) $validated['admin_pct'], 2);
        $profitPct = round(100 - $adminPct, 2);

        $changes = [];

        if ($fee !== $oldFee) {
            Setting::set('application_form_fee', $fee);
            ActivityLog::record('registration_fee.amount_changed', 'Changed the registration fee from ₦'.number_format($oldFee, 2).' to ₦'.number_format($fee, 2).'.', null, ['from' => $oldFee, 'to' => $fee]);
            $changes[] = 'fee set to ₦'.number_format($fee, 2);
        }

        if ($adminPct !== (float) $oldSplit['admin_pct']) {
            Setting::set('application_fee_admin_pct', $adminPct);
            Setting::set('application_fee_profit_pct', $profitPct);
            ActivityLog::record('registration_fee.split_changed', "Updated registration fee split to {$adminPct}% admin / {$profitPct}% profit.", null, ['admin_pct' => $adminPct, 'profit_pct' => $profitPct]);
            $changes[] = "split set to {$adminPct}% admin / {$profitPct}% profit";
        }

        session()->flash('status', $changes
            ? ucfirst(implode(' and ', $changes)).'. This applies to new registrations only — fees already paid are unchanged.'
            : 'No changes made.');

        $this->closeSettingsForm();
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
            'currentFee' => ApplicationFeePayment::currentFee(),
            'totals' => $this->totals(),
            'bySource' => $this->bySource(),
            'byMonth' => $this->byMonth(),
            'recentPayments' => $this->successfulPayments()->with(['member', 'recordedBy'])->latest('paid_at')->limit(25)->get(),
        ]);
    }
}
