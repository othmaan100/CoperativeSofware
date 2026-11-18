<?php

namespace App\Livewire\Chairman;

use App\Livewire\Concerns\FiltersByDateRange;
use App\Models\ActivityLog;
use App\Models\WithdrawalCondition;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class WithdrawalsAuthorization extends Component
{
    use FiltersByDateRange;
    use WithPagination;

    public string $tab = 'pending';

    public ?int $activeId = null;

    public string $mode = '';

    public string $chairman_note = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('chairman_authorize_withdrawal'), 403);
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
        $request = WithdrawalRequest::with(['account', 'member'])->findOrFail($this->activeId);

        $violations = collect(WithdrawalCondition::evaluate($request->account, (float) $request->approved_amount, $request->id))
            ->filter(fn ($r) => ! $r['passed'])
            ->all();

        $minBalanceViolation = collect($violations)->firstWhere('rule_type', 'minimum_balance');

        if ($minBalanceViolation && ! Auth::user()->hasRole('super_admin')) {
            $this->addError('chairman_note', $minBalanceViolation['message'].' This cannot be authorized as-is.');

            return;
        }

        if (! empty($violations) && blank($this->chairman_note)) {
            $this->addError('chairman_note', 'Please note why this is authorized despite a rule warning.');

            return;
        }

        $request->update([
            'status' => 'chairman_authorized',
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->chairman_note ?: null,
        ]);

        ActivityLog::record(
            action: 'savings.withdrawal_authorized',
            description: "Authorized withdrawal of ₦{$request->approved_amount} for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['withdrawal_request_id' => $request->id, 'amount' => (float) $request->approved_amount],
        );

        session()->flash('status', 'Withdrawal authorized. Awaiting disbursement.');
        $this->closeModal();
    }

    public function decline(): void
    {
        $this->validate(['chairman_note' => ['required', 'string']]);

        $request = WithdrawalRequest::with('member')->findOrFail($this->activeId);
        $request->update([
            'status' => 'chairman_declined',
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->chairman_note,
        ]);

        ActivityLog::record(
            action: 'savings.withdrawal_declined',
            description: "Declined withdrawal request for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['withdrawal_request_id' => $request->id, 'reason' => $this->chairman_note],
        );

        session()->flash('status', 'Withdrawal declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = WithdrawalRequest::with(['member', 'account.product', 'treasurerReviewedBy', 'chairmanReviewedBy', 'disbursedBy']);

        if ($this->tab === 'history') {
            // Ordered and filtered by when each request was finished, so imported
            // legacy withdrawals fall into their real place in time.
            $completedAt = 'COALESCE(disbursed_at, chairman_reviewed_at, treasurer_reviewed_at, requested_at)';
            $query->whereIn('status', ['disbursed', 'chairman_authorized', 'chairman_declined']);
            if ($from = $this->validDate($this->dateFrom)) {
                $query->whereRaw("DATE({$completedAt}) >= ?", [$from]);
            }
            if ($to = $this->validDate($this->dateTo)) {
                $query->whereRaw("DATE({$completedAt}) <= ?", [$to]);
            }
            $query->orderByRaw("{$completedAt} DESC");
        } else {
            $query->where('status', 'treasurer_approved')->latest('treasurer_reviewed_at');
        }

        return view('livewire.chairman.withdrawals-authorization', [
            'requests' => $query->latest('id')->paginate(15),
            'activeRequest' => $this->activeId ? WithdrawalRequest::with('account')->find($this->activeId) : null,
        ]);
    }
}
