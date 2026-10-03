<?php

namespace App\Livewire\Reports;

use App\Models\WelfareClaim;
use App\Models\WelfareFund;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class WelfareReports extends Component
{
    use WithPagination;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_welfare_reports'), 403);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $fund = WelfareFund::singleton();

        $totalCollected = (float) $fund->transactions()->where('type', WelfareFund::TYPE_LEVY)->sum('amount');
        $totalDisbursed = (float) $fund->transactions()->where('type', WelfareFund::TYPE_PAYOUT)->sum('amount');

        $claimCounts = WelfareClaim::query()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('livewire.reports.welfare-reports', [
            'balance' => (float) $fund->balance,
            'totalCollected' => $totalCollected,
            'totalDisbursed' => $totalDisbursed,
            'claimCounts' => $claimCounts,
            'transactions' => $fund->transactions()->with('postedBy')->latest('posted_at')->paginate(15),
        ]);
    }
}
