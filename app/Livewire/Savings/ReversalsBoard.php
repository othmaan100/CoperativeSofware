<?php

namespace App\Livewire\Savings;

use App\Models\ActivityLog;
use App\Models\ReversalRequest;
use App\Models\SavingsTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ReversalsBoard extends Component
{
    use WithPagination;

    public string $original_transaction_id = '';

    public string $reason = '';

    public ?int $activeId = null;

    public string $mode = '';

    public string $decision_note = '';

    public function mount(): void
    {
        abort_unless(
            Auth::user()->can('initiate_reversal') || Auth::user()->can('authorize_reversal'),
            403
        );
    }

    #[Computed]
    public function previewTransaction(): ?SavingsTransaction
    {
        if (! is_numeric($this->original_transaction_id)) {
            return null;
        }

        return SavingsTransaction::with('account.member')->find($this->original_transaction_id);
    }

    public function initiate(): void
    {
        abort_unless(Auth::user()->can('initiate_reversal'), 403);

        $this->validate([
            'original_transaction_id' => ['required', 'exists:savings_transactions,id'],
            'reason' => ['required', 'string'],
        ]);

        $transaction = SavingsTransaction::with('account.member')->find($this->original_transaction_id);

        ReversalRequest::create([
            'original_transaction_id' => $this->original_transaction_id,
            'reason' => $this->reason,
            'initiated_by' => Auth::id(),
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        ActivityLog::record(
            action: 'savings.reversal_initiated',
            description: "Initiated a reversal of transaction #{$this->original_transaction_id} for {$transaction?->account?->member?->full_name}.",
            subject: $transaction?->account?->member,
            properties: ['original_transaction_id' => (int) $this->original_transaction_id, 'reason' => $this->reason],
        );

        $this->reset(['original_transaction_id', 'reason']);
        session()->flash('status', 'Reversal request submitted for Chairman authorization.');
    }

    public function openAuthorize(int $id): void
    {
        $this->activeId = $id;
        $this->mode = 'authorize';
        $this->decision_note = '';
    }

    public function openDecline(int $id): void
    {
        $this->activeId = $id;
        $this->mode = 'decline';
        $this->decision_note = '';
    }

    public function closeModal(): void
    {
        $this->reset(['activeId', 'mode', 'decision_note']);
    }

    public function authorize_(): void
    {
        abort_unless(Auth::user()->can('authorize_reversal'), 403);

        $reversal = ReversalRequest::with('originalTransaction.account')->findOrFail($this->activeId);

        if ($reversal->status !== 'pending') {
            return;
        }

        $original = $reversal->originalTransaction;
        $correctingType = $original->isCredit() ? 'reversal_debit' : 'reversal_credit';

        $correcting = $original->account->recordTransaction(
            type: $correctingType,
            amount: (float) $original->amount,
            description: "Reversal of transaction #{$original->id}: {$reversal->reason}",
            postedBy: Auth::id(),
            reference: "REV-{$reversal->id}",
            reversedTransactionId: $original->id,
        );

        $reversal->update([
            'status' => 'applied',
            'authorized_by' => Auth::id(),
            'authorized_at' => now(),
            'resulting_transaction_id' => $correcting->id,
        ]);

        ActivityLog::record(
            action: 'savings.reversal_authorized',
            description: "Authorized reversal of transaction #{$original->id} for {$original->account->member->full_name}.",
            subject: $original->account->member,
            properties: ['reversal_request_id' => $reversal->id, 'amount' => (float) $original->amount],
        );

        session()->flash('status', 'Reversal authorized and correcting entry posted.');
        $this->closeModal();
    }

    public function decline(): void
    {
        abort_unless(Auth::user()->can('authorize_reversal'), 403);

        $this->validate(['decision_note' => ['required', 'string']]);

        $reversal = ReversalRequest::with('originalTransaction.account.member')->findOrFail($this->activeId);
        $reversal->update([
            'status' => 'declined',
            'authorized_by' => Auth::id(),
            'authorized_at' => now(),
            'decline_reason' => $this->decision_note,
        ]);

        ActivityLog::record(
            action: 'savings.reversal_declined',
            description: "Declined reversal request for transaction #{$reversal->original_transaction_id}.",
            subject: $reversal->originalTransaction?->account?->member,
            properties: ['reversal_request_id' => $reversal->id, 'reason' => $this->decision_note],
        );

        session()->flash('status', 'Reversal request declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.savings.reversals-board', [
            'reversals' => ReversalRequest::with(['originalTransaction.account.member', 'initiatedBy', 'authorizedBy'])
                ->latest('requested_at')
                ->paginate(15),
        ]);
    }
}
