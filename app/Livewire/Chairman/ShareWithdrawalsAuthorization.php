<?php

namespace App\Livewire\Chairman;

use App\Models\ActivityLog;
use App\Models\ShareWithdrawalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ShareWithdrawalsAuthorization extends Component
{
    use WithPagination;

    public string $tab = 'pending';

    public ?int $activeId = null;

    public string $mode = '';

    public string $chairman_note = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('chairman_authorize_share_withdrawal'), 403);
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
        $request = ShareWithdrawalRequest::with(['account', 'member'])->findOrFail($this->activeId);

        $max = $request->account->maxWithdrawableShares($request->id);
        if ((int) $request->shares_approved > $max) {
            $this->addError('chairman_note', "This would breach the minimum holding requirement (max {$max} share(s) right now). It cannot be authorized as-is.");

            return;
        }

        $request->update([
            'status' => 'chairman_authorized',
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->chairman_note ?: null,
        ]);

        ActivityLog::record(
            action: 'share.withdrawal_authorized',
            description: "Authorized {$request->shares_approved} share(s) withdrawal for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['share_withdrawal_request_id' => $request->id, 'shares' => $request->shares_approved],
        );

        session()->flash('status', 'Share withdrawal authorized. Awaiting disbursement.');
        $this->closeModal();
    }

    public function decline(): void
    {
        $this->validate(['chairman_note' => ['required', 'string']]);

        $request = ShareWithdrawalRequest::with('member')->findOrFail($this->activeId);
        $request->update([
            'status' => 'chairman_declined',
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->chairman_note,
        ]);

        ActivityLog::record(
            action: 'share.withdrawal_declined',
            description: "Declined share withdrawal request for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['share_withdrawal_request_id' => $request->id, 'reason' => $this->chairman_note],
        );

        session()->flash('status', 'Share withdrawal declined.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = ShareWithdrawalRequest::with(['member', 'account']);

        match ($this->tab) {
            'history' => $query->whereIn('status', ['disbursed', 'chairman_authorized', 'chairman_declined']),
            default => $query->where('status', 'treasurer_approved'),
        };

        return view('livewire.chairman.share-withdrawals-authorization', [
            'requests' => $query->latest('treasurer_reviewed_at')->paginate(15),
            'activeRequest' => $this->activeId ? ShareWithdrawalRequest::with('account')->find($this->activeId) : null,
        ]);
    }
}
