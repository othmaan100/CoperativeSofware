<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\WithdrawalCondition;
use App\Models\WithdrawalRequest;
use App\Notifications\SavingsWithdrawalDisbursedNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class WithdrawalsReview extends Component
{
    use WithPagination;

    public string $tab = 'pending';

    public ?int $activeId = null;

    public string $mode = '';

    public string $approved_amount = '';

    public string $treasurer_note = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('treasurer_review_withdrawal'), 403);
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function openReview(int $id): void
    {
        $request = WithdrawalRequest::findOrFail($id);
        $this->activeId = $id;
        $this->mode = 'review';
        $this->approved_amount = (string) $request->requested_amount;
        $this->treasurer_note = '';
    }

    public function openReject(int $id): void
    {
        $this->activeId = $id;
        $this->mode = 'reject';
        $this->treasurer_note = '';
    }

    public function closeModal(): void
    {
        $this->reset(['activeId', 'mode', 'approved_amount', 'treasurer_note']);
    }

    public function warningsFor(WithdrawalRequest $request, float $amount): array
    {
        return collect(WithdrawalCondition::evaluate($request->account, $amount, $request->id))
            ->filter(fn ($r) => ! $r['passed'])
            ->all();
    }

    public function approve(): void
    {
        $request = WithdrawalRequest::with(['account', 'member'])->findOrFail($this->activeId);

        $validated = $this->validate([
            'approved_amount' => ['required', 'numeric', 'min:1'],
            'treasurer_note' => ['nullable', 'string'],
        ]);

        $amount = (float) $validated['approved_amount'];
        $violations = $this->warningsFor($request, $amount);
        $minBalanceViolation = collect($violations)->firstWhere('rule_type', 'minimum_balance');

        if ($minBalanceViolation && ! Auth::user()->hasRole('super_admin')) {
            $this->addError('approved_amount', $minBalanceViolation['message'].' Reduce the amount to proceed.');

            return;
        }

        if (! empty($violations) && blank($validated['treasurer_note'])) {
            $this->addError('treasurer_note', 'Please note why this request is being approved despite a rule warning.');

            return;
        }

        $request->update([
            'approved_amount' => $amount,
            'status' => 'treasurer_approved',
            'treasurer_reviewed_by' => Auth::id(),
            'treasurer_reviewed_at' => now(),
            'treasurer_note' => $validated['treasurer_note'] ?: null,
        ]);

        ActivityLog::record(
            action: 'savings.withdrawal_endorsed',
            description: "Endorsed withdrawal of ₦{$amount} for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['withdrawal_request_id' => $request->id, 'amount' => $amount],
        );

        session()->flash('status', 'Withdrawal endorsed and sent to Chairman for authorization.');
        $this->closeModal();
    }

    public function reject(): void
    {
        $this->validate(['treasurer_note' => ['required', 'string']]);

        $request = WithdrawalRequest::with('member')->findOrFail($this->activeId);
        $request->update([
            'status' => 'treasurer_rejected',
            'treasurer_reviewed_by' => Auth::id(),
            'treasurer_reviewed_at' => now(),
            'treasurer_note' => $this->treasurer_note,
        ]);

        ActivityLog::record(
            action: 'savings.withdrawal_rejected',
            description: "Rejected withdrawal request for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['withdrawal_request_id' => $request->id, 'reason' => $this->treasurer_note],
        );

        session()->flash('status', 'Withdrawal request rejected.');
        $this->closeModal();
    }

    public function disburse(int $id): void
    {
        abort_unless(Auth::user()->can('disburse_withdrawal'), 403);

        $request = WithdrawalRequest::with(['account', 'member'])->findOrFail($id);

        if ($request->status !== 'chairman_authorized') {
            return;
        }

        $description = $request->isComplete()
            ? ($request->isForNextOfKin() ? 'Complete withdrawal disbursement to next of kin' : 'Complete withdrawal disbursement')
            : 'Withdrawal disbursement';

        $request->account->recordTransaction(
            type: 'withdrawal',
            amount: (float) $request->approved_amount,
            description: $description,
            postedBy: Auth::id(),
            reference: "WD-{$request->id}",
            withdrawalRequestId: $request->id,
        );

        $request->update([
            'status' => 'disbursed',
            'disbursed_by' => Auth::id(),
            'disbursed_at' => now(),
        ]);

        ActivityLog::record(
            action: 'savings.withdrawal_disbursed',
            description: "Disbursed withdrawal of ₦{$request->approved_amount} for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['withdrawal_request_id' => $request->id, 'amount' => (float) $request->approved_amount],
        );

        if (! $request->isForNextOfKin()) {
            $request->member->user?->notify(new SavingsWithdrawalDisbursedNotification((float) $request->approved_amount));
        }

        $flash = 'Withdrawal marked as disbursed and posted to the ledger.';

        if ($request->isComplete() && ! $request->isForNextOfKin() && $request->member->status !== 'suspended') {
            $request->member->transitionTo('suspended', Auth::id(), 'Automatically suspended after complete withdrawal disbursement.');
            $request->member->logEvent('complete_withdrawal_disbursed', ['withdrawal_request_id' => $request->id], Auth::id());
            $flash = 'Complete withdrawal disbursed. The member\'s account has been suspended.';
        } elseif ($request->isComplete() && $request->isForNextOfKin()) {
            $request->member->logEvent('deceased_disbursement_completed', ['withdrawal_request_id' => $request->id], Auth::id());
            $flash = 'Disbursement to next of kin completed.';
        }

        session()->flash('status', $flash);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = WithdrawalRequest::with(['member', 'account.product']);

        match ($this->tab) {
            'disbursement' => $query->where('status', 'chairman_authorized'),
            'history' => $query->whereIn('status', ['disbursed', 'treasurer_rejected', 'chairman_declined', 'cancelled']),
            default => $query->where('status', 'pending'),
        };

        return view('livewire.treasurer.withdrawals-review', [
            'requests' => $query->latest('requested_at')->paginate(15),
            'activeRequest' => $this->activeId ? WithdrawalRequest::with('account')->find($this->activeId) : null,
        ]);
    }
}
