<?php

namespace App\Livewire\Treasurer;

use App\Events\MemberApproved;
use App\Models\ActivityLog;
use App\Models\ApplicationFeePayment;
use App\Models\Member;
use App\Notifications\ApplicationApprovedNotification;
use App\Notifications\ApplicationRejectedNotification;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class PendingApplications extends Component
{
    use WithPagination;

    public ?int $activeMemberId = null;

    public string $mode = ''; // 'approve' | 'reject'

    public string $approved_monthly_contribution = '';

    public string $adjustment_note = '';

    public bool $application_fee_paid = false;

    public string $fee_override_note = '';

    public string $rejection_reason = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('approve_applications'), 403);
    }

    public function openApprove(int $memberId): void
    {
        $member = Member::findOrFail($memberId);
        $this->authorize('approve', $member);

        $this->activeMemberId = $memberId;
        $this->mode = 'approve';
        $this->approved_monthly_contribution = (string) $member->preferred_monthly_contribution;
        $this->adjustment_note = '';
        $this->application_fee_paid = $member->application_fee_paid;
        $this->fee_override_note = '';
    }

    public function openReject(int $memberId): void
    {
        $this->authorize('reject', Member::findOrFail($memberId));

        $this->activeMemberId = $memberId;
        $this->mode = 'reject';
        $this->rejection_reason = '';
    }

    public function closeModal(): void
    {
        $this->reset(['activeMemberId', 'mode', 'approved_monthly_contribution', 'adjustment_note', 'application_fee_paid', 'fee_override_note', 'rejection_reason']);
    }

    public function approve(): void
    {
        $member = Member::findOrFail($this->activeMemberId);
        $this->authorize('approve', $member);

        $minContribution = (float) Setting::get('minimum_monthly_contribution', 5000);

        $validated = $this->validate([
            'approved_monthly_contribution' => ['required', 'numeric', "min:{$minContribution}"],
            'adjustment_note' => ['nullable', 'string'],
        ]);

        $isAdjusted = bccomp((string) $validated['approved_monthly_contribution'], (string) $member->preferred_monthly_contribution, 2) !== 0;

        if ($isAdjusted && blank($validated['adjustment_note'])) {
            $this->addError('adjustment_note', 'Please explain why the contribution amount was adjusted.');

            return;
        }

        $isManualOverride = $this->application_fee_paid && ! $member->application_fee_paid;

        if (! $member->application_fee_paid && ! $this->application_fee_paid) {
            $this->addError('application_fee_paid', 'The application fee must be paid via Paystack, or confirmed manually below, before this application can be approved.');

            return;
        }

        if ($isManualOverride && blank($this->fee_override_note)) {
            $this->addError('fee_override_note', 'Please note how and when the fee was paid (e.g. bank transfer reference) for the audit trail.');

            return;
        }

        $user = Auth::user();

        $member->membership_no = $member->generateMembershipNo();
        $member->approved_monthly_contribution = $validated['approved_monthly_contribution'];
        $member->approved_by = $user->id;
        $member->approved_at = now();

        if ($isManualOverride) {
            $member->application_fee_paid = true;
            $member->application_fee_paid_at = now();
            $member->application_fee_source = 'manual';
            $member->application_fee_marked_by = $user->id;
        }

        $member->save();

        if ($isManualOverride) {
            ApplicationFeePayment::recordManual(
                member: $member,
                amount: (float) Setting::get('application_form_fee', 5000),
                recordedBy: $user->id,
                note: $this->fee_override_note,
            );

            $member->logEvent('application_fee_paid', [
                'source' => 'manual',
                'note' => $this->fee_override_note,
            ], $user->id);
        }

        $member->transitionTo('active', $user->id, $isAdjusted ? "Approved with adjusted contribution: {$this->adjustment_note}" : 'Application approved.');

        $member->user?->syncRoles(['member']);

        $member->logEvent('application_approved', [
            'approved_monthly_contribution' => $validated['approved_monthly_contribution'],
            'adjusted' => $isAdjusted,
        ], $user->id);

        ActivityLog::record(
            action: 'member.approved',
            description: "Approved application {$member->application_no} for {$member->full_name} (Membership No: {$member->membership_no}).",
            subject: $member,
            properties: ['approved_monthly_contribution' => (float) $validated['approved_monthly_contribution'], 'fee_manual_override' => $isManualOverride],
        );

        MemberApproved::dispatch($member);

        $member->user?->notify(new ApplicationApprovedNotification($member->membership_no));

        session()->flash('status', "Application {$member->application_no} approved. Membership No: {$member->membership_no}.");
        $this->closeModal();
    }

    public function reject(): void
    {
        $member = Member::findOrFail($this->activeMemberId);
        $this->authorize('reject', $member);

        $this->validate(['rejection_reason' => ['required', 'string']]);

        $user = Auth::user();

        $member->update([
            'rejected_at' => now(),
            'rejection_reason' => $this->rejection_reason,
        ]);

        $member->statusHistory()->create([
            'from_status' => 'pending',
            'to_status' => 'rejected',
            'changed_by' => $user->id,
            'reason' => $this->rejection_reason,
        ]);

        $member->logEvent('application_rejected', ['reason' => $this->rejection_reason], $user->id);

        ActivityLog::record(
            action: 'member.rejected',
            description: "Rejected application {$member->application_no} for {$member->full_name}.",
            subject: $member,
            properties: ['reason' => $this->rejection_reason],
        );

        $member->user?->notify(new ApplicationRejectedNotification($this->rejection_reason));

        session()->flash('status', "Application {$member->application_no} rejected.");
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.pending-applications', [
            'applications' => Member::pendingQueue()->latest('applied_at')->paginate(15),
            'activeMember' => $this->activeMemberId ? Member::find($this->activeMemberId) : null,
        ]);
    }
}
