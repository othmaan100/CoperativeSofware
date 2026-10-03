<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\VoluntaryDepositIntent;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class VoluntaryDeposits extends Component
{
    use WithPagination;

    public ?int $activeIntentId = null;

    public string $decline_reason = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('confirm_voluntary_deposit'), 403);
    }

    public function confirm(int $intentId): void
    {
        $intent = VoluntaryDepositIntent::with('account.member')->findOrFail($intentId);

        if ($intent->status !== 'pending') {
            return;
        }

        $transaction = $intent->account->recordTransaction(
            type: 'voluntary_deposit',
            amount: (float) $intent->amount,
            description: $intent->note ?: 'Voluntary savings deposit',
            postedBy: Auth::id(),
            reference: "VOL-{$intent->id}",
        );

        $intent->update([
            'status' => 'confirmed',
            'confirmed_by' => Auth::id(),
            'confirmed_at' => now(),
            'transaction_id' => $transaction->id,
        ]);

        ActivityLog::record(
            action: 'savings.voluntary_deposit_confirmed',
            description: "Confirmed voluntary deposit of ₦{$intent->amount} for {$intent->account->member->full_name}.",
            subject: $intent->account->member,
            properties: ['amount' => (float) $intent->amount],
        );

        session()->flash('status', 'Deposit confirmed and posted.');
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

        $intent = VoluntaryDepositIntent::with('account.member')->findOrFail($this->activeIntentId);
        $intent->update([
            'status' => 'declined',
            'confirmed_by' => Auth::id(),
            'confirmed_at' => now(),
            'decline_reason' => $this->decline_reason,
        ]);

        ActivityLog::record(
            action: 'savings.voluntary_deposit_declined',
            description: "Declined voluntary deposit of ₦{$intent->amount} for {$intent->account->member->full_name}.",
            subject: $intent->account->member,
            properties: ['amount' => (float) $intent->amount, 'reason' => $this->decline_reason],
        );

        session()->flash('status', 'Deposit intent declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.voluntary-deposits', [
            'intents' => VoluntaryDepositIntent::with(['member', 'account.product'])
                ->where('status', 'pending')
                ->latest('requested_at')
                ->paginate(15),
        ]);
    }
}
