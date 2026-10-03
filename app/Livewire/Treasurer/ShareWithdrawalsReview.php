<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\ShareWithdrawalRequest;
use App\Notifications\ShareWithdrawalDisbursedNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ShareWithdrawalsReview extends Component
{
    use WithPagination;

    public string $tab = 'pending';

    public ?int $activeId = null;

    public string $mode = '';

    public string $shares_approved = '';

    public string $treasurer_note = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('treasurer_review_share_withdrawal'), 403);
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function openReview(int $id): void
    {
        $request = ShareWithdrawalRequest::findOrFail($id);
        $this->activeId = $id;
        $this->mode = 'review';
        $this->shares_approved = (string) $request->shares_requested;
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
        $this->reset(['activeId', 'mode', 'shares_approved', 'treasurer_note']);
    }

    public function approve(): void
    {
        $request = ShareWithdrawalRequest::with(['account', 'member'])->findOrFail($this->activeId);

        $validated = $this->validate([
            'shares_approved' => ['required', 'integer', 'min:1'],
            'treasurer_note' => ['nullable', 'string'],
        ]);

        $shares = (int) $validated['shares_approved'];
        $max = $request->account->maxWithdrawableShares($request->id);

        if ($shares > $max) {
            $this->addError('shares_approved', "This would breach the minimum holding requirement. At most {$max} share(s) can be approved.");

            return;
        }

        $request->update([
            'shares_approved' => $shares,
            'status' => 'treasurer_approved',
            'treasurer_reviewed_by' => Auth::id(),
            'treasurer_reviewed_at' => now(),
            'treasurer_note' => $validated['treasurer_note'] ?: null,
        ]);

        ActivityLog::record(
            action: 'share.withdrawal_endorsed',
            description: "Endorsed withdrawal of {$shares} share(s) for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['share_withdrawal_request_id' => $request->id, 'shares' => $shares],
        );

        session()->flash('status', 'Share withdrawal endorsed and sent to Chairman for authorization.');
        $this->closeModal();
    }

    public function reject(): void
    {
        $this->validate(['treasurer_note' => ['required', 'string']]);

        $request = ShareWithdrawalRequest::with('member')->findOrFail($this->activeId);
        $request->update([
            'status' => 'treasurer_rejected',
            'treasurer_reviewed_by' => Auth::id(),
            'treasurer_reviewed_at' => now(),
            'treasurer_note' => $this->treasurer_note,
        ]);

        ActivityLog::record(
            action: 'share.withdrawal_rejected',
            description: "Rejected share withdrawal request for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['share_withdrawal_request_id' => $request->id, 'reason' => $this->treasurer_note],
        );

        session()->flash('status', 'Share withdrawal request rejected.');
        $this->closeModal();
    }

    public function disburse(int $id): void
    {
        abort_unless(Auth::user()->can('disburse_share_withdrawal'), 403);

        $request = ShareWithdrawalRequest::with(['account', 'member'])->findOrFail($id);

        if ($request->status !== 'chairman_authorized') {
            return;
        }

        $request->account->recordTransaction(
            type: 'withdrawal',
            shares: (int) $request->shares_approved,
            unitPrice: \App\Models\SharePriceHistory::currentPrice(),
            description: 'Share withdrawal disbursement',
            postedBy: Auth::id(),
            reference: "SHAREWD-{$request->id}",
            withdrawalRequestId: $request->id,
        );

        $request->update([
            'status' => 'disbursed',
            'disbursed_by' => Auth::id(),
            'disbursed_at' => now(),
        ]);

        ActivityLog::record(
            action: 'share.withdrawal_disbursed',
            description: "Disbursed {$request->shares_approved} share(s) withdrawal for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['share_withdrawal_request_id' => $request->id, 'shares' => $request->shares_approved],
        );

        $request->member->user?->notify(new ShareWithdrawalDisbursedNotification((int) $request->shares_approved));

        session()->flash('status', 'Share withdrawal marked as disbursed and posted to the ledger.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = ShareWithdrawalRequest::with(['member', 'account']);

        match ($this->tab) {
            'disbursement' => $query->where('status', 'chairman_authorized'),
            'history' => $query->whereIn('status', ['disbursed', 'treasurer_rejected', 'chairman_declined', 'cancelled']),
            default => $query->where('status', 'pending'),
        };

        return view('livewire.treasurer.share-withdrawals-review', [
            'requests' => $query->latest('requested_at')->paginate(15),
            'activeRequest' => $this->activeId ? ShareWithdrawalRequest::with('account')->find($this->activeId) : null,
        ]);
    }
}
