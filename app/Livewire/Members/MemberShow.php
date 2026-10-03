<?php

namespace App\Livewire\Members;

use App\Models\ActivityLog;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MemberShow extends Component
{
    public Member $member;

    public string $action_reason = '';

    public string $pendingAction = '';

    // Locked-field editor (Super Admin only)
    public bool $editingLocked = false;

    public string $department = '';

    public string $staff_id = '';

    public string $rank_grade = '';

    public string $staff_category = '';

    public function mount(Member $member): void
    {
        $this->authorize('view', $member);
        $this->member = $member;
        $this->department = (string) $member->department;
        $this->staff_id = $member->staff_id;
        $this->rank_grade = (string) $member->rank_grade;
        $this->staff_category = (string) $member->staff_category;
    }

    protected function refreshMember(): void
    {
        $this->member->refresh();
    }

    protected function isSuperAdmin(): bool
    {
        return Auth::user()->hasRole('super_admin');
    }

    public function confirmAction(string $action): void
    {
        $this->pendingAction = $action;
        $this->action_reason = '';
    }

    public function cancelAction(): void
    {
        $this->pendingAction = '';
        $this->action_reason = '';
    }

    public function suspend(): void
    {
        abort_unless($this->isSuperAdmin(), 403);
        $this->validate(['action_reason' => ['required', 'string']]);

        $this->member->transitionTo('suspended', Auth::id(), $this->action_reason);
        $this->member->logEvent('status_changed', ['to' => 'suspended', 'reason' => $this->action_reason], Auth::id());
        ActivityLog::record('member.suspended', "Suspended {$this->member->full_name} ({$this->member->membership_no}).", $this->member, ['reason' => $this->action_reason]);

        $this->cancelAction();
        session()->flash('status', 'Member suspended.');
    }

    public function reactivateFromSuspended(): void
    {
        abort_unless($this->isSuperAdmin(), 403);

        $this->member->transitionTo('active', Auth::id(), 'Reinstated from suspension.');
        $this->member->logEvent('status_changed', ['to' => 'active'], Auth::id());
        ActivityLog::record('member.reactivated', "Reactivated {$this->member->full_name} ({$this->member->membership_no}) from suspension.", $this->member);

        session()->flash('status', 'Member reinstated to active.');
    }

    public function confirmDormant(): void
    {
        abort_unless($this->isSuperAdmin(), 403);

        $this->member->transitionTo('dormant', Auth::id(), 'Confirmed dormant after '.\App\Models\Setting::get('dormancy_months', 6).' months of no contribution.');
        $this->member->logEvent('status_changed', ['to' => 'dormant'], Auth::id());
        ActivityLog::record('member.marked_dormant', "Marked {$this->member->full_name} ({$this->member->membership_no}) dormant.", $this->member);

        session()->flash('status', 'Member marked dormant.');
    }

    public function reactivateFromDormant(): void
    {
        abort_unless(Auth::user()->can('manage_member_status'), 403);

        $this->member->update(['dormant_flagged_at' => null]);
        $this->member->transitionTo('active', Auth::id(), 'Resumed contributions.');
        $this->member->logEvent('status_changed', ['to' => 'active'], Auth::id());
        ActivityLog::record('member.reactivated', "Reactivated {$this->member->full_name} ({$this->member->membership_no}) from dormancy.", $this->member);

        session()->flash('status', 'Member reactivated from dormancy.');
    }

    public function markDeceased(): void
    {
        abort_unless($this->isSuperAdmin(), 403);
        $this->validate(['action_reason' => ['required', 'string']]);

        $this->member->transitionTo('deceased', Auth::id(), $this->action_reason);
        $this->member->logEvent('status_changed', ['to' => 'deceased', 'reason' => $this->action_reason], Auth::id());
        ActivityLog::record('member.marked_deceased', "Recorded {$this->member->full_name} ({$this->member->membership_no}) as deceased.", $this->member, ['reason' => $this->action_reason]);

        $this->cancelAction();
        session()->flash('status', 'Member recorded as deceased.');
    }

    public function treasurerSignOff(): void
    {
        abort_unless(Auth::user()->can('manage_member_status'), 403);
        abort_unless($this->member->exit_requested_at && ! $this->member->exit_treasurer_cleared, 400);

        $this->member->update([
            'exit_treasurer_cleared' => true,
            'exit_cleared_by' => Auth::id(),
            'exit_cleared_at' => now(),
        ]);

        $this->member->logEvent('exit_treasurer_cleared', [
            'has_outstanding_loans' => $this->member->hasOutstandingLoans(),
            'has_guarantor_obligations' => $this->member->hasActiveGuarantorObligations(),
            'savings_shares_balance' => $this->member->savingsSharesBalance(),
        ], Auth::id());
        ActivityLog::record('member.exit_treasurer_cleared', "Treasurer signed off exit clearance for {$this->member->full_name} ({$this->member->membership_no}).", $this->member);

        session()->flash('status', 'Exit clearance signed off by Treasurer.');
    }

    public function finalizeExit(): void
    {
        abort_unless($this->isSuperAdmin(), 403);
        abort_unless($this->member->exit_treasurer_cleared, 400);

        $this->member->update(['exited_at' => now()]);
        $this->member->transitionTo('exited', Auth::id(), $this->member->exit_reason);
        $this->member->logEvent('member_exited', [], Auth::id());
        ActivityLog::record('member.exit_finalized', "Finalized exit for {$this->member->full_name} ({$this->member->membership_no}).", $this->member);

        session()->flash('status', 'Member exit finalized.');
    }

    public function saveLockedFields(): void
    {
        abort_unless($this->isSuperAdmin(), 403);

        $validated = $this->validate([
            'department' => ['required', 'string', 'max:255'],
            'staff_id' => ['required', 'string', 'max:50', 'unique:members,staff_id,'.$this->member->id],
            'rank_grade' => ['nullable', 'string', 'max:100'],
            'staff_category' => ['nullable', 'in:senior_staff,junior_staff'],
        ]);

        $changes = [];
        foreach ($validated as $field => $value) {
            if ((string) $this->member->{$field} !== (string) $value) {
                $changes[$field] = ['from' => $this->member->{$field}, 'to' => $value];
            }
        }

        $this->member->update($validated);

        if (! empty($changes)) {
            $this->member->logEvent('locked_field_updated', $changes, Auth::id());
            ActivityLog::record('member.locked_fields_updated', "Updated locked fields for {$this->member->full_name} ({$this->member->membership_no}).", $this->member, $changes);
        }

        $this->editingLocked = false;
        session()->flash('status', 'Locked fields updated.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->member->load([
            'nextOfKin',
            'statusHistory.changedBy',
            'changeRequests.requestedBy',
            'changeRequests.reviewedBy',
            'events.causedBy',
            'withdrawalRequests' => fn ($query) => $query->where('type', 'complete')->latest('requested_at'),
            'savingsAccounts.product',
            'shareAccount',
            'loans' => fn ($query) => $query->whereIn('status', \App\Models\Loan::ACTIVE_STATUSES)->with('product')->latest('disbursed_at'),
            'welfareClaims' => fn ($query) => $query->latest(),
        ]);

        return view('livewire.members.member-show');
    }
}
