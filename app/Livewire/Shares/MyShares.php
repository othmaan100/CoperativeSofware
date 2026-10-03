<?php

namespace App\Livewire\Shares;

use App\Models\Member;
use App\Models\SharePriceHistory;
use App\Models\ShareAccount;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MyShares extends Component
{
    public Member $member;

    public bool $showPurchaseModal = false;

    public string $shares_requested = '';

    public string $purchase_note = '';

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();

        if ($this->member->status === 'active') {
            ShareAccount::openFor($this->member);
        }
    }

    public function openPurchaseModal(): void
    {
        abort_unless($this->member->status === 'active', 403, 'Only active members can purchase shares.');
        abort_unless(Auth::user()->can('purchase_shares'), 403);

        $this->showPurchaseModal = true;
        $this->shares_requested = '';
        $this->purchase_note = '';
    }

    public function closePurchaseModal(): void
    {
        $this->showPurchaseModal = false;
    }

    public function submitPurchase(): void
    {
        abort_unless($this->member->status === 'active', 403, 'Only active members can purchase shares.');

        $validated = $this->validate([
            'shares_requested' => ['required', 'integer', 'min:1'],
            'purchase_note' => ['nullable', 'string'],
        ]);

        $account = $this->member->shareAccount ?? ShareAccount::openFor($this->member);

        $account->purchaseIntents()->create([
            'member_id' => $this->member->id,
            'shares_requested' => $validated['shares_requested'],
            'note' => $validated['purchase_note'] ?: null,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        $this->closePurchaseModal();
        session()->flash('status', 'Share purchase logged. It will reflect once the Treasurer confirms receipt of payment.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $account = $this->member->shareAccount;

        return view('livewire.shares.my-shares', [
            'account' => $account,
            'currentPrice' => SharePriceHistory::currentPrice(),
            'pendingIntents' => $account?->purchaseIntents()->where('status', 'pending')->latest('requested_at')->get() ?? collect(),
            'pendingWithdrawals' => $this->member->shareWithdrawalRequests()->whereNotIn('status', ['disbursed', 'cancelled', 'chairman_declined', 'treasurer_rejected'])->latest('requested_at')->get(),
        ]);
    }
}
