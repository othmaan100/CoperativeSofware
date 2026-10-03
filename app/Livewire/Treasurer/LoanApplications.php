<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\Loan;
use App\Notifications\LoanDisbursedNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LoanApplications extends Component
{
    use WithPagination;

    public string $tab = 'pending';

    public ?int $activeId = null;

    public string $mode = '';

    public string $tenure_months = '';

    public string $treasurer_note = '';

    public string $disbursement_method = 'bank_transfer';

    public string $disbursement_reference = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('treasurer_review_loan'), 403);
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function openReview(int $id): void
    {
        $loan = Loan::findOrFail($id);
        $this->activeId = $id;
        $this->mode = 'review';
        $this->tenure_months = (string) $loan->tenure_months;
        $this->treasurer_note = '';
    }

    public function openReject(int $id): void
    {
        $this->activeId = $id;
        $this->mode = 'reject';
        $this->treasurer_note = '';
    }

    public function openDisburse(int $id): void
    {
        $this->activeId = $id;
        $this->mode = 'disburse';
        $this->disbursement_method = 'bank_transfer';
        $this->disbursement_reference = '';
    }

    public function closeModal(): void
    {
        $this->reset(['activeId', 'mode', 'tenure_months', 'treasurer_note', 'disbursement_method', 'disbursement_reference']);
    }

    public function endorse(): void
    {
        $loan = Loan::with(['member', 'product'])->findOrFail($this->activeId);

        $validated = $this->validate([
            'tenure_months' => ['required', 'integer', 'min:1', 'max:'.$loan->product->max_tenure_months],
            'treasurer_note' => ['nullable', 'string'],
        ]);

        $eligibility = Loan::evaluateEligibility($loan->member, $loan->product, (float) $loan->principal_amount);

        if (! empty($eligibility['violations']) && blank($validated['treasurer_note'])) {
            $this->addError('treasurer_note', 'This loan no longer clears the savings-linked eligibility check. Please note why you are endorsing it anyway: '.implode(' ', $eligibility['violations']));

            return;
        }

        $tenure = (int) $validated['tenure_months'];
        $monthlyInstallment = $tenure > 0 ? round((float) $loan->total_repayable / $tenure, 2) : $loan->total_repayable;

        $loan->update([
            'tenure_months' => $tenure,
            'monthly_installment' => $monthlyInstallment,
            'status' => 'treasurer_endorsed',
            'treasurer_reviewed_by' => Auth::id(),
            'treasurer_reviewed_at' => now(),
            'treasurer_note' => $validated['treasurer_note'] ?: null,
        ]);

        ActivityLog::record(
            action: 'loan.endorsed',
            description: "Endorsed loan {$loan->loan_no} of ₦{$loan->principal_amount} for {$loan->member->full_name}.",
            subject: $loan,
            properties: ['principal_amount' => (float) $loan->principal_amount, 'tenure_months' => $tenure],
        );

        session()->flash('status', 'Loan endorsed and sent to Chairman for authorization.');
        $this->closeModal();
    }

    public function reject(): void
    {
        $this->validate(['treasurer_note' => ['required', 'string']]);

        $loan = Loan::with('member')->findOrFail($this->activeId);
        $loan->update([
            'status' => 'treasurer_rejected',
            'treasurer_reviewed_by' => Auth::id(),
            'treasurer_reviewed_at' => now(),
            'treasurer_note' => $this->treasurer_note,
        ]);

        ActivityLog::record(
            action: 'loan.rejected',
            description: "Rejected loan {$loan->loan_no} for {$loan->member->full_name}.",
            subject: $loan,
            properties: ['reason' => $this->treasurer_note],
        );

        session()->flash('status', 'Loan application rejected.');
        $this->closeModal();
    }

    public function disburse(): void
    {
        abort_unless(Auth::user()->can('disburse_loan'), 403);

        $validated = $this->validate([
            'disbursement_method' => ['required', 'in:cash,bank_transfer'],
            'disbursement_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $loan = Loan::with('member')->findOrFail($this->activeId);

        if ($loan->status !== 'chairman_authorized') {
            return;
        }

        $loan->update([
            'status' => 'disbursed',
            'disbursed_by' => Auth::id(),
            'disbursed_at' => now(),
            'disbursement_method' => $validated['disbursement_method'],
            'disbursement_reference' => $validated['disbursement_reference'] ?: null,
        ]);

        $loan->generateSchedule(now());
        $loan->update(['status' => 'active']);

        ActivityLog::record(
            action: 'loan.disbursed',
            description: "Disbursed loan {$loan->loan_no} of ₦{$loan->principal_amount} to {$loan->member->full_name}.",
            subject: $loan,
            properties: ['principal_amount' => (float) $loan->principal_amount, 'method' => $validated['disbursement_method']],
        );

        $loan->member->user?->notify(new LoanDisbursedNotification($loan));

        session()->flash('status', 'Loan disbursed and repayment schedule generated.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = Loan::with(['member', 'product']);

        match ($this->tab) {
            'awaiting_guarantor' => $query->where('status', 'pending_guarantor'),
            'endorsed' => $query->where('status', 'treasurer_endorsed'),
            'disbursement' => $query->where('status', 'chairman_authorized'),
            'history' => $query->whereIn('status', ['disbursed', 'active', 'overdue', 'defaulted', 'closed', 'treasurer_rejected', 'chairman_declined', 'guarantor_declined']),
            default => $query->where('status', 'pending'),
        };

        return view('livewire.treasurer.loan-applications', [
            'loans' => $query->latest('applied_at')->paginate(15),
            'activeLoan' => $this->activeId ? Loan::with(['member', 'product'])->find($this->activeId) : null,
        ]);
    }
}
