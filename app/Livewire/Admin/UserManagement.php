<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\User;
use App\Notifications\PasswordResetByAdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public string $search = '';

    public string $roleFilter = '';

    public ?int $activeUserId = null;

    public string $new_password = '';

    public string $new_password_confirmation = '';

    public bool $require_change = true;

    public function mount(): void
    {
        abort_unless(Auth::user()->can('manage_users'), 403);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function openChangePassword(int $userId): void
    {
        abort_if($userId === Auth::id(), 403, 'Use your own Profile page to change your own password.');

        $this->activeUserId = $userId;
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->require_change = true;
        $this->resetErrorBag();
    }

    public function closeModal(): void
    {
        $this->reset(['activeUserId', 'new_password', 'new_password_confirmation', 'require_change']);
    }

    protected function rules(): array
    {
        return [
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function changePassword(): void
    {
        abort_if($this->activeUserId === Auth::id(), 403);

        $validated = $this->validate();

        $target = User::with('member')->findOrFail($this->activeUserId);

        $target->forceFill([
            'password' => Hash::make($validated['new_password']),
            'must_change_password' => $this->require_change,
        ])->save();

        if ($target->member) {
            $target->member->logEvent('password_reset_by_admin', [
                'requires_change_at_next_login' => $this->require_change,
            ], Auth::id());
        }

        ActivityLog::record(
            action: 'admin.password_reset',
            description: "Reset password for {$target->name}.",
            subject: $target,
            properties: ['requires_change_at_next_login' => $this->require_change],
        );

        $target->notify(new PasswordResetByAdminNotification($this->require_change));

        session()->flash('status', "Password updated for {$target->name}.".($this->require_change ? ' They will be asked to set a new one at next login.' : ''));
        $this->closeModal();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $query = User::query()->with(['roles', 'member'])->orderBy('name');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhereHas('member', fn ($m) => $m->where('staff_id', 'like', "%{$this->search}%"));
            });
        }

        if ($this->roleFilter !== '') {
            $query->whereHas('roles', fn ($r) => $r->where('name', $this->roleFilter));
        }

        return view('livewire.admin.user-management', [
            'users' => $query->paginate(15),
            'roles' => \Spatie\Permission\Models\Role::orderBy('name')->pluck('name'),
            'activeUser' => $this->activeUserId ? User::find($this->activeUserId) : null,
        ]);
    }
}
