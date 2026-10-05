<?php

namespace App\Livewire\Chairman;

use App\Models\ActivityLog;
use App\Models\LoanTenureChangeRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use RuntimeException;

class LoanTenureApprovals extends Component
{
    use WithPagination;

    public string $tab = 'pending';

    public ?int $activeId = null;

    public string $mode = '';

    public string $chairman_note = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('chairman_authorize_loan'), 403);
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function openApprove(int $id): void
    {
        $this->resetValidation();
        $this->activeId = $id;
        $this->mode = 'approve';
        $this->chairman_note = '';
    }

    public function openDecline(int $id): void
    {
        $this->resetValidation();
        $this->activeId = $id;
        $this->mode = 'decline';
        $this->chairman_note = '';
    }

    public function closeModal(): void
    {
        $this->reset(['activeId', 'mode', 'chairman_note']);
        $this->resetValidation();
    }

    public function approve(): void
    {
        $request = LoanTenureChangeRequest::with(['loan', 'member'])->findOrFail($this->activeId);

        try {
            $request->approve(Auth::id(), $this->chairman_note);
        } catch (RuntimeException $e) {
            $this->addError('chairman_note', $e->getMessage());

            return;
        }

        ActivityLog::record(
            action: 'loan.tenure_change_approved',
            description: "Approved tenure increase for loan {$request->loan->loan_no} ({$request->member->full_name}) to {$request->requested_tenure_months} months; monthly repayment now ₦".number_format((float) $request->applied_installment, 2).'.',
            subject: $request,
            properties: ['to' => (int) $request->requested_tenure_months, 'installment' => (float) $request->applied_installment],
        );

        session()->flash('status', "Tenure for loan {$request->loan->loan_no} extended to {$request->requested_tenure_months} months.");
        $this->closeModal();
    }

    public function decline(): void
    {
        $this->validate(['chairman_note' => ['required', 'string', 'max:1000']]);

        $request = LoanTenureChangeRequest::with(['loan', 'member'])->findOrFail($this->activeId);

        if ($request->status !== LoanTenureChangeRequest::STATUS_PENDING) {
            $this->addError('chairman_note', 'This request has already been reviewed.');

            return;
        }

        $request->update([
            'status' => LoanTenureChangeRequest::STATUS_DECLINED,
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->chairman_note,
        ]);

        ActivityLog::record(
            action: 'loan.tenure_change_declined',
            description: "Declined tenure increase for loan {$request->loan->loan_no} ({$request->member->full_name}).",
            subject: $request,
            properties: ['reason' => $this->chairman_note],
        );

        session()->flash('status', 'Tenure change declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = LoanTenureChangeRequest::with(['loan', 'member', 'requestedBy']);

        $this->tab === 'history'
            ? $query->where('status', '!=', LoanTenureChangeRequest::STATUS_PENDING)->latest('chairman_reviewed_at')
            : $query->where('status', LoanTenureChangeRequest::STATUS_PENDING)->oldest('requested_at');

        $active = $this->activeId ? LoanTenureChangeRequest::with(['loan', 'member'])->find($this->activeId) : null;

        return view('livewire.chairman.loan-tenure-approvals', [
            'requests' => $query->paginate(15),
            'active' => $active,
            // Repayments may have posted since the request was raised, so show
            // what the installment would be if approved right now.
            'currentProposal' => $active && $active->status === LoanTenureChangeRequest::STATUS_PENDING
                ? $active->loan->installmentForTenure((int) $active->requested_tenure_months)
                : null,
        ]);
    }
}
