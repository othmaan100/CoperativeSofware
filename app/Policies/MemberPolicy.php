<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;

class MemberPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_all_members');
    }

    public function view(User $user, Member $member): bool
    {
        return $user->can('view_all_members') || $member->user_id === $user->id;
    }

    public function updateOwnProfile(User $user, Member $member): bool
    {
        return $member->user_id === $user->id && $user->can('edit_own_profile');
    }

    public function approve(User $user, Member $member): bool
    {
        return $user->can('approve_applications');
    }

    public function reject(User $user, Member $member): bool
    {
        return $user->can('reject_applications');
    }

    public function adjustContribution(User $user, Member $member): bool
    {
        return $user->can('adjust_contribution');
    }

    public function markFeePaid(User $user, Member $member): bool
    {
        return $user->can('mark_application_fee_paid');
    }

    public function reviewChangeRequests(User $user, Member $member): bool
    {
        return $user->can('review_change_requests');
    }

    public function editLockedFields(User $user, Member $member): bool
    {
        return $user->can('edit_locked_fields');
    }

    public function manageStatus(User $user, Member $member): bool
    {
        return $user->can('manage_member_status');
    }

    public function requestExit(User $user, Member $member): bool
    {
        return ($member->user_id === $user->id && $user->can('request_exit'))
            || $user->can('manage_member_status');
    }

    public function export(User $user): bool
    {
        return $user->can('export_reports');
    }
}
