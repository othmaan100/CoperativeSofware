<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\Loan;
use App\Models\LoanTenureChangeRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LoanTenureChanges extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $loanId = null;

    public string $new_tenure = '';

    public string $reason = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('treasurer_review_loan'), 403);
    }

    public function updatedSearch(): void
    {
        $this->resetPage('loansPage');
    }

    public function openRequest(int $loanId): void
    {
        $this->resetValidation();
        $this->loanId = $loanId;
        $this->new_tenure = '';
        $this->reason = '';
    }

    public function closeRequest(): void
    {
        $this->reset(['loanId', 'new_tenure', 'reason']);
        $this->resetValidation();
    }

    public function submitRequest(): void
    {
        $this->validate([
            'new_tenure' => ['required', 'integer', 'min:1'],
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $loan = Loan::with('member')->findOrFail($this->loanId);
        $tenure = (int) $this->new_tenure;

        if ($error = $loan->tenureExtensionError($tenure)) {
            $this->addError('new_tenure', $error);

            return;
        }

        if ($loan->tenureChangeRequests()->where('status', LoanTenureChangeRequest::STATUS_PENDING)->exists()) {
            $this->addError('new_tenure', 'This loan already has a tenure change awaiting the Chairman.');

            return;
        }

        $request = $loan->tenureChangeRequests()->create([
            'member_id' => $loan->member_id,
            'current_tenure_months' => $loan->tenure_months,
            'requested_tenure_months' => $tenure,
            'current_installment' => $loan->monthly_installment,
            'proposed_installment' => $loan->installmentForTenure($tenure),
            'reason' => $this->reason,
            'status' => LoanTenureChangeRequest::STATUS_PENDING,
            'requested_by' => Auth::id(),
            'requested_at' => now(),
        ]);

        ActivityLog::record(
            action: 'loan.tenure_change_requested',
            description: "Requested tenure increase for loan {$loan->loan_no} ({$loan->member->full_name}) from {$loan->tenure_months} to {$tenure} months.",
            subject: $request,
            properties: ['from' => (int) $loan->tenure_months, 'to' => $tenure],
        );

        session()->flash('status', "Tenure increase for loan {$loan->loan_no} sent to the Chairman for approval.");
        $this->closeRequest();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $search = trim($this->search);

        $loans = Loan::query()
            ->with(['member', 'product'])
            ->withExists(['tenureChangeRequests as has_pending_tenure_change' => fn ($q) => $q->where('status', LoanTenureChangeRequest::STATUS_PENDING)])
            ->whereIn('status', ['active', 'overdue', 'defaulted'])
            ->where('outstanding_balance', '>', 0)
            ->when($search !== '', fn ($q) => $q->where(fn ($q) => $q
                ->where('loan_no', 'like', "%{$search}%")
                ->orWhereHas('member', fn ($m) => $m->where('full_name', 'like', "%{$search}%")->orWhere('staff_id', 'like', "%{$search}%"))))
            ->latest('disbursed_at')
            ->paginate(15, pageName: 'loansPage');

        $activeLoan = $this->loanId ? Loan::with(['member', 'product'])->find($this->loanId) : null;
        $tenure = (int) $this->new_tenure;

        return view('livewire.treasurer.loan-tenure-changes', [
            'loans' => $loans,
            'activeLoan' => $activeLoan,
            'previewInstallment' => $activeLoan && $tenure > (int) $activeLoan->tenure_months && $tenure <= 120
                ? $activeLoan->installmentForTenure($tenure)
                : null,
            'requests' => LoanTenureChangeRequest::with(['loan', 'member', 'chairmanReviewedBy'])
                ->latest('requested_at')->latest('id')
                ->paginate(10, pageName: 'requestsPage'),
        ]);
    }
}
