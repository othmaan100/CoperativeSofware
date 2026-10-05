<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\LoanRepaymentReversal;
use App\Notifications\LoanRepaymentReversalNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LoanRepaymentReversals extends Component
{
    use WithPagination;

    public ?int $refundReversalId = null;

    public string $refund_reference = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('confirm_loan_repayment'), 403);
    }

    protected function pendingReversal(int $reversalId, string $resolution): ?LoanRepaymentReversal
    {
        $reversal = LoanRepaymentReversal::with(['member.user', 'loan', 'targetLoan'])->findOrFail($reversalId);

        return $reversal->status === LoanRepaymentReversal::STATUS_AWAITING_PROCESSING && $reversal->resolution === $resolution
            ? $reversal
            : null;
    }

    public function applyToLoan(int $reversalId): void
    {
        $reversal = $this->pendingReversal($reversalId, LoanRepaymentReversal::RESOLUTION_APPLY_TO_LOAN);
        if (! $reversal) {
            return;
        }

        $target = $reversal->targetLoan;

        if (! $target || ! in_array($target->status, ['active', 'overdue', 'defaulted'], true)) {
            $reversal->update([
                'status' => LoanRepaymentReversal::STATUS_AWAITING_CHOICE,
                'resolution' => null,
                'target_loan_id' => null,
                'chosen_at' => null,
            ]);
            session()->flash('error', "Loan {$target?->loan_no} is no longer active, so the excess can't be applied to it. It has been sent back to the member to choose again.");

            return;
        }

        DB::transaction(function () use ($reversal, $target) {
            $transaction = $target->recordRepayment(
                type: 'reversal_transfer',
                amount: (float) $reversal->amount,
                postedBy: Auth::id(),
                reference: "REVERSAL-{$reversal->id}",
                description: "Excess repayment transferred from loan {$reversal->loan->loan_no}",
            );

            $reversal->update([
                'status' => LoanRepaymentReversal::STATUS_COMPLETED,
                'applied_transaction_id' => $transaction->id,
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);
        });

        ActivityLog::record(
            action: 'loan.repayment_reversal_applied',
            description: "Applied ₦{$reversal->amount} excess from loan {$reversal->loan->loan_no} to loan {$target->loan_no} for {$reversal->member->full_name}.",
            subject: $reversal->loan,
            properties: ['reversal_id' => $reversal->id, 'amount' => (float) $reversal->amount, 'target_loan' => $target->loan_no],
        );

        $reversal->member->user?->notify(new LoanRepaymentReversalNotification($reversal->fresh(['loan', 'targetLoan'])));

        session()->flash('status', "₦".number_format((float) $reversal->amount, 2)." applied to loan {$target->loan_no}. Reversal completed.");
    }

    public function openRefund(int $reversalId): void
    {
        $this->refundReversalId = $reversalId;
        $this->refund_reference = '';
        $this->resetErrorBag();
    }

    public function closeRefund(): void
    {
        $this->refundReversalId = null;
    }

    public function completeRefund(): void
    {
        $this->validate(['refund_reference' => ['required', 'string', 'max:255']]);

        $reversal = $this->pendingReversal($this->refundReversalId, LoanRepaymentReversal::RESOLUTION_REFUND);
        if (! $reversal) {
            $this->closeRefund();

            return;
        }

        $reversal->update([
            'status' => LoanRepaymentReversal::STATUS_COMPLETED,
            'refund_reference' => $this->refund_reference,
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        ActivityLog::record(
            action: 'loan.repayment_reversal_refunded',
            description: "Refunded ₦{$reversal->amount} excess from loan {$reversal->loan->loan_no} to {$reversal->member->full_name} (ref: {$this->refund_reference}).",
            subject: $reversal->loan,
            properties: ['reversal_id' => $reversal->id, 'amount' => (float) $reversal->amount, 'reference' => $this->refund_reference],
        );

        $reversal->member->user?->notify(new LoanRepaymentReversalNotification($reversal->fresh('loan')));

        $this->closeRefund();
        session()->flash('status', 'Refund recorded. Reversal completed.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.loan-repayment-reversals', [
            'awaitingProcessing' => LoanRepaymentReversal::with(['member', 'loan', 'targetLoan'])
                ->where('status', LoanRepaymentReversal::STATUS_AWAITING_PROCESSING)
                ->oldest('chosen_at')
                ->paginate(15),
            'awaitingChoice' => LoanRepaymentReversal::with(['member', 'loan'])
                ->where('status', LoanRepaymentReversal::STATUS_AWAITING_CHOICE)
                ->oldest()
                ->get(),
            'completed' => LoanRepaymentReversal::with(['member', 'loan', 'targetLoan', 'processedBy'])
                ->where('status', LoanRepaymentReversal::STATUS_COMPLETED)
                ->latest('processed_at')
                ->limit(15)
                ->get(),
            'refundReversal' => $this->refundReversalId ? LoanRepaymentReversal::with(['member', 'loan'])->find($this->refundReversalId) : null,
        ]);
    }
}
