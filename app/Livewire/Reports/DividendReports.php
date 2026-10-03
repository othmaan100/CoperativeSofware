<?php

namespace App\Livewire\Reports;

use App\Models\DividendAllocation;
use App\Models\DividendPeriod;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DividendReports extends Component
{
    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_dividend_reports'), 403);
    }

    protected function topRecipients()
    {
        return DividendAllocation::query()
            ->selectRaw('member_id, SUM(share_dividend_amount) as total_dividend, SUM(savings_interest_amount) as total_interest')
            ->where('status', 'posted')
            ->groupBy('member_id')
            ->orderByDesc('total_dividend')
            ->with('member')
            ->limit(20)
            ->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.reports.dividend-reports', [
            'periods' => DividendPeriod::query()->latest('fy_start_date')->get(),
            'topRecipients' => $this->topRecipients(),
        ]);
    }
}
