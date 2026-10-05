<?php

namespace App\Livewire\Loans;

use App\Models\Loan;
use App\Models\LoanRepaymentReversal;
use App\Models\LoanSavingsRepaymentRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class MyLoans extends Component
{
    use WithFileUploads;

    public Member $member;

    public ?int $expandedLoanId = null;

    public ?int $repayLoanId = null;

    public string $repay_amount = '';

    public string $repay_note = '';

    public $repay_receipt;

    public ?int $repayFromSavingsLoanId = null;

    public string $repay_from_savings_account_id = '';

    public string $repay_from_savings_amount = '';

    public ?int $reversalId = null;

    public string $reversal_action = '';

    public string $reversal_target_loan_id = '';

    public string $refund_bank_name = '';

    public string $refund_account_number = '';

    public string $refund_account_name = '';

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();
    }

    public function toggleExpand(int $loanId): void
    {
        $this->expandedLoanId = $this->expandedLoanId === $loanId ? null : $loanId;
    }

    public function openRepay(int $loanId): void
    {
        $this->repayLoanId = $loanId;
        $this->repay_amount = '';
        $this->repay_note = '';
        $this->reset(['repay_receipt']);
    }

    public function closeRepay(): void
    {
        $this->repayLoanId = null;
        $this->reset(['repay_receipt']);
    }

    public function submitRepayment(): void
    {
        $validated = $this->validate([
            'repay_amount' => ['required', 'numeric', 'min:1'],
            'repay_note' => ['nullable', 'string'],
            'repay_receipt' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $loan = $this->member->loans()->findOrFail($this->repayLoanId);

        $receiptPath = $this->repay_receipt?->store('receipts/loan-repayments', 'local');

        $loan->repaymentIntents()->create([
            'member_id' => $this->member->id,
            'amount' => $validated['repay_amount'],
            'note' => $validated['repay_note'] ?: null,
            'receipt_path' => $receiptPath,
            'receipt_original_filename' => $this->repay_receipt?->getClientOriginalName(),
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        $this->closeRepay();
        session()->flash('status', 'Repayment logged. It will reflect once the Treasurer confirms receipt.');
    }

    public function openRepayFromSavings(int $loanId): void
    {
        $this->repayFromSavingsLoanId = $loanId;
        $this->repay_from_savings_account_id = '';
        $this->repay_from_savings_amount = '';
    }

    public function closeRepayFromSavings(): void
    {
        $this->repayFromSavingsLoanId = null;
    }

    public function submitRepayFromSavings(): void
    {
        $validated = $this->validate([
            'repay_from_savings_account_id' => ['required', 'exists:savings_accounts,id'],
            'repay_from_savings_amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $loan = $this->member->loans()->findOrFail($this->repayFromSavingsLoanId);
        $account = $this->member->savingsAccounts()->findOrFail($validated['repay_from_savings_account_id']);

        $maxRepayable = min($account->withdrawableBalance(), (float) $loan->outstanding_balance);

        if ((float) $validated['repay_from_savings_amount'] > $maxRepayable) {
            $this->addError(
                'repay_from_savings_amount',
                'You can repay at most ₦'.number_format($maxRepayable, 2).' this way right now — this cannot exceed either your withdrawable savings balance or the loan\'s outstanding amount.'
            );

            return;
        }

        LoanSavingsRepaymentRequest::create([
            'loan_id' => $loan->id,
            'member_id' => $this->member->id,
            'savings_account_id' => $account->id,
            'amount' => $validated['repay_from_savings_amount'],
            'status' => LoanSavingsRepaymentRequest::STATUS_PENDING,
            'requested_at' => now(),
        ]);

        $this->closeRepayFromSavings();
        session()->flash('status', 'Repayment-from-savings request submitted. It will transfer once the Treasurer approves it.');
    }

    public function openReversal(int $reversalId): void
    {
        $reversal = $this->member->repaymentReversals()->findOrFail($reversalId);
        abort_unless($reversal->status === LoanRepaymentReversal::STATUS_AWAITING_CHOICE, 400);

        $this->reversalId = $reversal->id;
        $this->reversal_action = $this->activeLoansForTransfer()->isNotEmpty()
            ? LoanRepaymentReversal::RESOLUTION_APPLY_TO_LOAN
            : LoanRepaymentReversal::RESOLUTION_REFUND;
        $this->reversal_target_loan_id = '';
        $this->refund_bank_name = '';
        $this->refund_account_number = '';
        $this->refund_account_name = $this->member->full_name;
        $this->resetErrorBag();
    }

    public function closeReversal(): void
    {
        $this->reversalId = null;
    }

    public function submitReversalChoice(): void
    {
        $reversal = $this->member->repaymentReversals()->findOrFail($this->reversalId);
        abort_unless($reversal->status === LoanRepaymentReversal::STATUS_AWAITING_CHOICE, 400);

        $activeLoanIds = $this->activeLoansForTransfer()->pluck('id')->map(fn ($id) => (string) $id)->all();

        $validated = $this->validate([
            'reversal_action' => ['required', Rule::in([LoanRepaymentReversal::RESOLUTION_APPLY_TO_LOAN, LoanRepaymentReversal::RESOLUTION_REFUND])],
            'reversal_target_loan_id' => [
                Rule::requiredIf($this->reversal_action === LoanRepaymentReversal::RESOLUTION_APPLY_TO_LOAN),
                'nullable',
                Rule::in($activeLoanIds),
            ],
            'refund_bank_name' => [Rule::requiredIf($this->reversal_action === LoanRepaymentReversal::RESOLUTION_REFUND), 'nullable', 'string', 'max:255'],
            'refund_account_number' => [Rule::requiredIf($this->reversal_action === LoanRepaymentReversal::RESOLUTION_REFUND), 'nullable', 'string', 'max:50'],
            'refund_account_name' => [Rule::requiredIf($this->reversal_action === LoanRepaymentReversal::RESOLUTION_REFUND), 'nullable', 'string', 'max:255'],
        ], [
            'reversal_target_loan_id.in' => 'Choose one of your active loans.',
        ]);

        $isRefund = $validated['reversal_action'] === LoanRepaymentReversal::RESOLUTION_REFUND;

        $reversal->update([
            'status' => LoanRepaymentReversal::STATUS_AWAITING_PROCESSING,
            'resolution' => $validated['reversal_action'],
            'target_loan_id' => $isRefund ? null : (int) $validated['reversal_target_loan_id'],
            'bank_name' => $isRefund ? $validated['refund_bank_name'] : null,
            'account_number' => $isRefund ? $validated['refund_account_number'] : null,
            'account_name' => $isRefund ? $validated['refund_account_name'] : null,
            'chosen_at' => now(),
        ]);

        $this->closeReversal();
        session()->flash('status', $isRefund
            ? 'Refund requested. The Treasurer will pay it into your bank account.'
            : 'Transfer requested. The Treasurer will apply it to your chosen loan.');
    }

    protected function activeLoansForTransfer()
    {
        return $this->member->loans()->whereIn('status', ['active', 'overdue', 'defaulted'])->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.loans.my-loans', [
            'reversals' => $this->member->repaymentReversals()->with(['loan', 'targetLoan'])->latest()->get(),
            'transferLoans' => $this->reversalId ? $this->activeLoansForTransfer() : collect(),
            'activeReversal' => $this->reversalId ? $this->member->repaymentReversals()->with('loan')->find($this->reversalId) : null,
            'loans' => $this->member->loans()->with(['product', 'guarantors.guarantorMember', 'schedules', 'savingsRepaymentRequests' => fn ($q) => $q->latest('requested_at'), 'repaymentIntents' => fn ($q) => $q->latest('requested_at')->latest('id')])->latest('applied_at')->get(),
            'savingsAccounts' => $this->member->savingsAccounts()->with('product')->get(),
        ]);
    }
}
