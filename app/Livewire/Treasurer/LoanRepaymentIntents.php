<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\LoanRepaymentIntent;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LoanRepaymentIntents extends Component
{
    use WithPagination;

    public ?int $activeIntentId = null;

    public string $decline_reason = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('confirm_loan_repayment'), 403);
    }

    public function confirm(int $intentId): void
    {
        $intent = LoanRepaymentIntent::with(['loan.member'])->findOrFail($intentId);

        if ($intent->status !== 'pending') {
            return;
        }

        $transaction = $intent->loan->recordRepayment(
            type: 'voluntary_lump_sum',
            amount: (float) $intent->amount,
            postedBy: Auth::id(),
            reference: "LOANINTENT-{$intent->id}",
            description: $intent->note ?: 'Voluntary lump-sum loan repayment',
        );

        $intent->update([
            'status' => 'confirmed',
            'confirmed_by' => Auth::id(),
            'confirmed_at' => now(),
            'transaction_id' => $transaction->id,
        ]);

        ActivityLog::record(
            action: 'loan.repayment_confirmed',
            description: "Confirmed lump-sum repayment of ₦{$intent->amount} on loan {$intent->loan->loan_no} for {$intent->loan->member->full_name}.",
            subject: $intent->loan,
            properties: ['amount' => (float) $intent->amount],
        );

        session()->flash('status', 'Repayment confirmed and posted.');
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

        $intent = LoanRepaymentIntent::with('loan.member')->findOrFail($this->activeIntentId);
        $intent->update([
            'status' => 'declined',
            'confirmed_by' => Auth::id(),
            'confirmed_at' => now(),
            'decline_reason' => $this->decline_reason,
        ]);

        ActivityLog::record(
            action: 'loan.repayment_declined',
            description: "Declined lump-sum repayment of ₦{$intent->amount} on loan {$intent->loan->loan_no}.",
            subject: $intent->loan,
            properties: ['amount' => (float) $intent->amount, 'reason' => $this->decline_reason],
        );

        session()->flash('status', 'Repayment intent declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.loan-repayment-intents', [
            'intents' => LoanRepaymentIntent::with(['member', 'loan.product'])
                ->where('status', 'pending')
                ->latest('requested_at')
                ->paginate(15),
        ]);
    }
}
