<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\SharePriceHistory;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SharePriceManager extends Component
{
    public bool $showPriceForm = false;

    public string $unit_price = '';

    public string $effective_from = '';

    public string $minimum_share_holding = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_share_price'), 403);
        $this->minimum_share_holding = (string) Setting::get('minimum_share_holding', 5);
    }

    public function openPriceForm(): void
    {
        $this->unit_price = (string) SharePriceHistory::currentPrice();
        $this->effective_from = now()->toDateString();
        $this->showPriceForm = true;
    }

    public function closePriceForm(): void
    {
        $this->showPriceForm = false;
    }

    public function savePrice(): void
    {
        $validated = $this->validate([
            'unit_price' => ['required', 'numeric', 'min:0.01'],
            'effective_from' => ['required', 'date'],
        ]);

        SharePriceHistory::query()->where('is_active', true)->update(['is_active' => false]);

        $price = SharePriceHistory::create([
            'unit_price' => $validated['unit_price'],
            'effective_from' => $validated['effective_from'],
            'set_by' => Auth::id(),
            'is_active' => true,
        ]);

        ActivityLog::record('share.price_changed', "Set share price to ₦{$validated['unit_price']}, effective {$validated['effective_from']}.", $price, $validated);

        session()->flash('status', 'New share price set. Purchases and withdrawals already recorded keep the price that applied at the time.');
        $this->closePriceForm();
    }

    public function saveMinimumHolding(): void
    {
        $validated = $this->validate([
            'minimum_share_holding' => ['required', 'integer', 'min:0'],
        ]);

        Setting::set('minimum_share_holding', (int) $validated['minimum_share_holding']);

        ActivityLog::record('share.minimum_holding_changed', "Set minimum share holding to {$validated['minimum_share_holding']} shares.", null, $validated);

        session()->flash('status', 'Minimum share holding updated.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.share-price-manager', [
            'history' => SharePriceHistory::query()->with('setBy')->orderByDesc('effective_from')->limit(10)->get(),
        ]);
    }
}
