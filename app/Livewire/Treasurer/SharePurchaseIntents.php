<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\SharePriceHistory;
use App\Models\SharePurchaseIntent;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class SharePurchaseIntents extends Component
{
    use WithPagination;

    public ?int $activeIntentId = null;

    public string $decline_reason = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('confirm_share_purchase'), 403);
    }

    public function confirm(int $intentId): void
    {
        $intent = SharePurchaseIntent::with('account.member')->findOrFail($intentId);

        if ($intent->status !== 'pending') {
            return;
        }

        $unitPrice = SharePriceHistory::currentPrice();

        $transaction = $intent->account->recordTransaction(
            type: 'purchase',
            shares: $intent->shares_requested,
            unitPrice: $unitPrice,
            description: $intent->note ?: 'Share purchase',
            postedBy: Auth::id(),
            reference: "SHAREINTENT-{$intent->id}",
        );

        $intent->update([
            'status' => 'confirmed',
            'confirmed_by' => Auth::id(),
            'confirmed_at' => now(),
            'transaction_id' => $transaction->id,
        ]);

        ActivityLog::record(
            action: 'share.purchase_confirmed',
            description: "Confirmed purchase of {$intent->shares_requested} share(s) for {$intent->account->member->full_name}.",
            subject: $intent->account->member,
            properties: ['shares' => $intent->shares_requested, 'unit_price' => $unitPrice],
        );

        session()->flash('status', 'Share purchase confirmed and posted.');
    }

    public function openDecline(int $intentId): void
    {
        $this->activeIntentId = $intentId;
        $this->decline_reason = '';
    }

    public function closeModal(): void
    {
        $this->activeIntentId = null;
    }

    public function decline(): void
    {
        $this->validate(['decline_reason' => ['required', 'string']]);

        $intent = SharePurchaseIntent::with('account.member')->findOrFail($this->activeIntentId);
        $intent->update([
            'status' => 'declined',
            'confirmed_by' => Auth::id(),
            'confirmed_at' => now(),
            'decline_reason' => $this->decline_reason,
        ]);

        ActivityLog::record(
            action: 'share.purchase_declined',
            description: "Declined purchase of {$intent->shares_requested} share(s) for {$intent->account->member->full_name}.",
            subject: $intent->account->member,
            properties: ['shares' => $intent->shares_requested, 'reason' => $this->decline_reason],
        );

        session()->flash('status', 'Share purchase intent declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.share-purchase-intents', [
            'intents' => SharePurchaseIntent::with(['member', 'account'])
                ->where('status', 'pending')
                ->latest('requested_at')
                ->paginate(15),
            'currentPrice' => SharePriceHistory::currentPrice(),
        ]);
    }
}
