<?php

namespace App\Livewire\Chairman;

use App\Livewire\Concerns\FiltersByDateRange;
use App\Models\ActivityLog;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class LoanAuthorizations extends Component
{
    use FiltersByDateRange;
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

    public function openAuthorize(int $id): void
    {
        $this->activeId = $id;
        $this->mode = 'authorize';
        $this->chairman_note = '';
    }

    public function openDecline(int $id): void
    {
        $this->activeId = $id;
        $this->mode = 'decline';
        $this->chairman_note = '';
    }

    public function closeModal(): void
    {
        $this->reset(['activeId', 'mode', 'chairman_note']);
    }

    public function authorize_(): void
    {
        $loan = Loan::with('member')->findOrFail($this->activeId);

        $loan->update([
            'status' => 'chairman_authorized',
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->chairman_note ?: null,
        ]);

        ActivityLog::record(
            action: 'loan.authorized',
            description: "Authorized loan {$loan->loan_no} of ₦{$loan->principal_amount} for {$loan->member->full_name}.",
            subject: $loan,
            properties: ['principal_amount' => (float) $loan->principal_amount],
        );

        session()->flash('status', 'Loan authorized. Awaiting Treasurer disbursement.');
        $this->closeModal();
    }

    public function decline(): void
    {
        $this->validate(['chairman_note' => ['required', 'string']]);

        $loan = Loan::with('member')->findOrFail($this->activeId);
        $loan->update([
            'status' => 'chairman_declined',
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->chairman_note,
        ]);

        ActivityLog::record(
            action: 'loan.declined',
            description: "Declined loan {$loan->loan_no} for {$loan->member->full_name}.",
            subject: $loan,
            properties: ['reason' => $this->chairman_note],
        );

        session()->flash('status', 'Loan declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = Loan::with(['member', 'product', 'guarantors.guarantorMember', 'treasurerReviewedBy', 'chairmanReviewedBy', 'disbursedBy']);

        if ($this->tab === 'history') {
            // Ordered and filtered by when each loan was disbursed (or, if it never
            // was, when the Chairman decided it), so imported loans sit at their real date.
            $settledAt = 'COALESCE(disbursed_at, chairman_reviewed_at, treasurer_reviewed_at, applied_at)';
            $query->whereIn('status', ['disbursed', 'active', 'overdue', 'defaulted', 'closed', 'chairman_authorized', 'chairman_declined']);
            if ($from = $this->validDate($this->dateFrom)) {
                $query->whereRaw("DATE({$settledAt}) >= ?", [$from]);
            }
            if ($to = $this->validDate($this->dateTo)) {
                $query->whereRaw("DATE({$settledAt}) <= ?", [$to]);
            }
            $query->orderByRaw("{$settledAt} DESC");
        } else {
            $query->where('status', 'treasurer_endorsed')->latest('treasurer_reviewed_at');
        }

        return view('livewire.chairman.loan-authorizations', [
            'loans' => $query->latest('id')->paginate(15),
            'activeLoan' => $this->activeId ? Loan::with(['member', 'product'])->find($this->activeId) : null,
        ]);
    }
}
