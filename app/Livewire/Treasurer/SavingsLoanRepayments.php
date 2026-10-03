<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\LoanSavingsRepaymentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class SavingsLoanRepayments extends Component
{
    use WithPagination;

    public ?int $activeRequestId = null;

    public string $decline_reason = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('confirm_loan_repayment'), 403);
    }

    public function approve(int $requestId): void
    {
        $repaymentRequest = LoanSavingsRepaymentRequest::with(['loan.member', 'savingsAccount'])->findOrFail($requestId);

        if ($repaymentRequest->status !== LoanSavingsRepaymentRequest::STATUS_PENDING) {
            return;
        }

        // Re-check against the CURRENT balance — time may have passed since
        // the member submitted this request, and other transactions may have
        // moved the account since then.
        $account = $repaymentRequest->savingsAccount;
        $maxRepayable = min(
            $account->withdrawableBalance(null, $repaymentRequest->id),
            (float) $repaymentRequest->loan->outstanding_balance,
        );

        if ((float) $repaymentRequest->amount > $maxRepayable) {
            session()->flash('error', "This request can no longer be approved as-is: at most ₦".number_format($maxRepayable, 2)." is available now. Ask the member to submit a smaller request.");

            return;
        }

        $userId = Auth::id();

        DB::transaction(function () use ($repaymentRequest, $account, $userId) {
            $reference = "LOANSAVINGS-{$repaymentRequest->id}";

            $debit = $account->recordTransaction(
                type: 'loan_repayment_transfer',
                amount: (float) $repaymentRequest->amount,
                description: "Transferred to repay loan {$repaymentRequest->loan->loan_no}",
                postedBy: $userId,
                reference: $reference,
            );

            $credit = $repaymentRequest->loan->recordRepayment(
                type: 'savings_transfer',
                amount: (float) $repaymentRequest->amount,
                postedBy: $userId,
                reference: $reference,
                description: "Repaid from {$repaymentRequest->savingsAccount->product->name} savings",
            );

            $repaymentRequest->update([
                'status' => LoanSavingsRepaymentRequest::STATUS_APPROVED,
                'reviewed_by' => $userId,
                'reviewed_at' => now(),
                'savings_transaction_id' => $debit->id,
                'loan_repayment_transaction_id' => $credit->id,
            ]);
        });

        ActivityLog::record(
            action: 'loan.savings_repayment_approved',
            description: "Approved ₦".number_format((float) $repaymentRequest->amount, 2)." repayment on loan {$repaymentRequest->loan->loan_no} from {$repaymentRequest->loan->member->full_name}'s savings.",
            subject: $repaymentRequest->loan,
            properties: ['amount' => (float) $repaymentRequest->amount],
        );

        session()->flash('status', 'Repayment approved and transferred from savings.');
    }

    public function openDecline(int $requestId): void
    {
        $this->activeRequestId = $requestId;
        $this->decline_reason = '';
    }

    public function closeModal(): void
    {
        $this->activeRequestId = null;
    }

    public function decline(): void
    {
        $this->validate(['decline_reason' => ['required', 'string']]);

        $repaymentRequest = LoanSavingsRepaymentRequest::with('loan')->findOrFail($this->activeRequestId);
        abort_unless($repaymentRequest->status === LoanSavingsRepaymentRequest::STATUS_PENDING, 400);

        $repaymentRequest->update([
            'status' => LoanSavingsRepaymentRequest::STATUS_DECLINED,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'decline_reason' => $this->decline_reason,
        ]);

        ActivityLog::record(
            action: 'loan.savings_repayment_declined',
            description: "Declined a ₦".number_format((float) $repaymentRequest->amount, 2)." savings repayment request on loan {$repaymentRequest->loan->loan_no}.",
            subject: $repaymentRequest->loan,
            properties: ['amount' => (float) $repaymentRequest->amount, 'reason' => $this->decline_reason],
        );

        session()->flash('status', 'Request declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.savings-loan-repayments', [
            'requests' => LoanSavingsRepaymentRequest::with(['member', 'loan.product', 'savingsAccount.product'])
                ->where('status', LoanSavingsRepaymentRequest::STATUS_PENDING)
                ->latest('requested_at')
                ->paginate(15),
        ]);
    }
}
