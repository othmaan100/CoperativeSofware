<?php

namespace App\Livewire\Members;

use App\Models\ActivityLog;
use App\Models\Member;
use App\Notifications\PasswordResetByAdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Secretary / Treasurer tool for staff members' login details: correct a
 * Staff ID (members log in with it) and reset a forgotten password.
 *
 * Officials' accounts (Chairman, Treasurer, Secretary, Super Admin, ...) are
 * off-limits here unless the user is a Super Admin, so nobody can take over
 * a more senior account by resetting its password.
 */
class StaffAccounts extends Component
{
    use WithPagination;

    /** Roles an ordinary staff member's account may hold. */
    public const ORDINARY_ROLES = ['member', 'applicant'];

    public string $search = '';

    public ?int $activeMemberId = null;

    public string $mode = '';

    public string $staff_id = '';

    public string $staff_id_reason = '';

    public string $password_method = 'staff_id';

    public string $new_password = '';

    public string $new_password_confirmation = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_staff_accounts'), 403);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openStaffId(int $memberId): void
    {
        $member = $this->manageableMember($memberId);

        $this->resetForm();
        $this->activeMemberId = $member->id;
        $this->mode = 'staff_id';
        $this->staff_id = $member->staff_id;
    }

    public function openPassword(int $memberId): void
    {
        $member = $this->manageableMember($memberId);
        abort_unless($member->user, 400, 'This member has no login account.');

        $this->resetForm();
        $this->activeMemberId = $member->id;
        $this->mode = 'password';
    }

    public function closeModal(): void
    {
        $this->resetForm();
    }

    public function saveStaffId(): void
    {
        $member = $this->manageableMember((int) $this->activeMemberId);

        $this->staff_id = trim($this->staff_id);
        $validated = $this->validate([
            'staff_id' => ['required', 'string', 'max:50', Rule::unique('members', 'staff_id')->ignore($member->id)],
            'staff_id_reason' => ['required', 'string', 'max:255'],
        ], [
            'staff_id.unique' => 'Another member already has this Staff ID.',
        ]);

        $old = $member->staff_id;
        if ($old === $validated['staff_id']) {
            $this->addError('staff_id', 'This is already the member\'s Staff ID.');

            return;
        }

        $member->update(['staff_id' => $validated['staff_id']]);

        $changes = ['staff_id' => ['from' => $old, 'to' => $validated['staff_id']], 'reason' => $validated['staff_id_reason']];
        $member->logEvent('locked_field_updated', $changes, Auth::id());
        ActivityLog::record(
            action: 'member.staff_id_updated',
            description: "Changed Staff ID for {$member->full_name} from {$old} to {$validated['staff_id']}.",
            subject: $member,
            properties: $changes,
        );

        session()->flash('status', "Staff ID for {$member->full_name} changed to {$validated['staff_id']}. They now log in with the new Staff ID.");
        $this->resetForm();
    }

    public function resetPassword(): void
    {
        $member = $this->manageableMember((int) $this->activeMemberId);
        $user = $member->user;
        abort_unless($user, 400, 'This member has no login account.');

        $this->validate([
            'password_method' => ['required', 'in:staff_id,custom'],
            'new_password' => $this->password_method === 'custom' ? ['required', 'string', 'min:8', 'confirmed'] : ['nullable'],
        ]);

        $password = $this->password_method === 'staff_id' ? $member->staff_id : $this->new_password;

        // A reset password is only temporary: the member always chooses their own at next login.
        $user->forceFill([
            'password' => Hash::make($password),
            'must_change_password' => true,
        ])->save();

        $member->logEvent('password_reset_by_admin', [
            'method' => $this->password_method,
            'requires_change_at_next_login' => true,
        ], Auth::id());

        ActivityLog::record(
            action: 'member.password_reset',
            description: "Reset password for {$member->full_name} ({$member->staff_id}).",
            subject: $user,
            properties: ['method' => $this->password_method, 'member_id' => $member->id],
        );

        $user->notify(new PasswordResetByAdminNotification(true));

        session()->flash('status', $this->password_method === 'staff_id'
            ? "Password for {$member->full_name} reset to their Staff ID ({$member->staff_id}). They must set a new one when they log in."
            : "Password for {$member->full_name} reset. They must set a new one when they log in.");
        $this->resetForm();
    }

    /** Whether the signed-in user may change this member's account. */
    public function canManage(Member $member): bool
    {
        $user = $member->user;

        if (! $user) {
            return true;
        }
        if ($user->id === Auth::id()) {
            return false;
        }
        if (Auth::user()->hasRole('super_admin')) {
            return true;
        }

        return $user->getRoleNames()->diff(self::ORDINARY_ROLES)->isEmpty();
    }

    protected function manageableMember(int $memberId): Member
    {
        $member = Member::with('user.roles')->findOrFail($memberId);

        abort_unless($this->canManage($member), 403, 'This account belongs to an official or to you. Ask the Super Admin.');

        return $member;
    }

    protected function resetForm(): void
    {
        $this->reset(['activeMemberId', 'mode', 'staff_id', 'staff_id_reason', 'password_method', 'new_password', 'new_password_confirmation']);
        $this->resetErrorBag();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = Member::query()
            ->with('user.roles')
            ->orderBy('full_name');

        if (($term = trim($this->search)) !== '') {
            $query->where(function ($q) use ($term) {
                $q->where('full_name', 'like', "%{$term}%")
                    ->orWhere('staff_id', 'like', "%{$term}%")
                    ->orWhere('membership_no', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });
        }

        return view('livewire.members.staff-accounts', [
            'members' => $query->paginate(20),
            'activeMember' => $this->activeMemberId ? Member::with('user')->find($this->activeMemberId) : null,
        ]);
    }
}
