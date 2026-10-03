<?php

namespace App\Livewire\Reports;

use App\Models\ShareAccount;
use App\Models\SharePriceHistory;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ShareReports extends Component
{
    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_share_reports'), 403);
    }

    protected function totals(): object
    {
        return ShareAccount::query()
            ->selectRaw('COUNT(*) as accounts, SUM(total_shares) as total_shares, SUM(balance) as total_balance')
            ->first();
    }

    protected function topShareholders()
    {
        return ShareAccount::with('member')
            ->where('total_shares', '>', 0)
            ->orderByDesc('total_shares')
            ->limit(20)
            ->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.reports.share-reports', [
            'totals' => $this->totals(),
            'currentPrice' => SharePriceHistory::currentPrice(),
            'topShareholders' => $this->topShareholders(),
        ]);
    }
}
