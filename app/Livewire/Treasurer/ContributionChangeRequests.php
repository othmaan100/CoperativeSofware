<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\ContributionChangeRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ContributionChangeRequests extends Component
{
    use WithPagination;

    public ?int $activeId = null;

    public string $mode = '';

    public string $approved_amount = '';

    public string $review_note = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('adjust_contribution'), 403);
    }

    public function openApprove(int $id): void
    {
        $request = ContributionChangeRequest::findOrFail($id);

        $this->activeId = $id;
        $this->mode = 'approve';
        $this->approved_amount = (string) $request->requested_amount;
        $this->review_note = '';
        $this->resetErrorBag();
    }

    public function openReject(int $id): void
    {
        $this->activeId = $id;
        $this->mode = 'reject';
        $this->review_note = '';
    }

    public function closeModal(): void
    {
        $this->reset(['activeId', 'mode', 'approved_amount', 'review_note']);
    }

    public function approve(): void
    {
        $request = ContributionChangeRequest::with('member')->findOrFail($this->activeId);

        if ($request->status !== 'pending') {
            return;
        }

        $minimum = (float) Setting::get('minimum_monthly_contribution', 5000);

        $validated = $this->validate([
            'approved_amount' => ['required', 'numeric', "min:{$minimum}"],
            'review_note' => ['nullable', 'string'],
        ]);

        $approvedAmount = (float) $validated['approved_amount'];
        $isAdjusted = bccomp((string) $approvedAmount, (string) $request->requested_amount, 2) !== 0;

        if ($isAdjusted && blank($validated['review_note'])) {
            $this->addError('review_note', 'Please explain why the approved amount differs from what the member requested.');

            return;
        }

        $member = $request->member;
        $member->update(['approved_monthly_contribution' => $approvedAmount]);

        $request->update([
            'approved_amount' => $approvedAmount,
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_note' => $validated['review_note'] ?: null,
        ]);

        $member->logEvent('contribution_change_approved', [
            'from' => (float) $request->current_amount,
            'requested' => (float) $request->requested_amount,
            'to' => $approvedAmount,
            'adjusted' => $isAdjusted,
        ], Auth::id());

        ActivityLog::record(
            action: 'member.contribution_change_approved',
            description: "Updated monthly contribution to ₦{$approvedAmount} for {$member->full_name}.",
            subject: $member,
            properties: ['from' => (float) $request->current_amount, 'to' => $approvedAmount],
        );

        session()->flash('status', "Contribution amount updated for {$member->full_name}.");
        $this->closeModal();
    }

    public function reject(): void
    {
        $this->validate(['review_note' => ['required', 'string']]);

        $request = ContributionChangeRequest::with('member')->findOrFail($this->activeId);

        if ($request->status !== 'pending') {
            return;
        }

        $request->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_note' => $this->review_note,
        ]);

        $request->member->logEvent('contribution_change_rejected', [
            'requested_amount' => (float) $request->requested_amount,
            'reason' => $this->review_note,
        ], Auth::id());

        ActivityLog::record(
            action: 'member.contribution_change_rejected',
            description: "Rejected contribution change request for {$request->member->full_name}.",
            subject: $request->member,
            properties: ['requested_amount' => (float) $request->requested_amount, 'reason' => $this->review_note],
        );

        session()->flash('status', 'Contribution change request rejected.');
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.contribution-change-requests', [
            'requests' => ContributionChangeRequest::with('member')
                ->where('status', 'pending')
                ->latest('requested_at')
                ->paginate(15),
            'activeRequest' => $this->activeId ? ContributionChangeRequest::find($this->activeId) : null,
        ]);
    }
}
