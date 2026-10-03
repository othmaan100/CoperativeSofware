<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ForceChangePassword extends Component
{
    public string $new_password = '';

    public string $new_password_confirmation = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->must_change_password, 404);
    }

    protected function rules(): array
    {
        $staffId = Auth::user()->member?->staff_id;

        return [
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                function ($attribute, $value, $fail) use ($staffId) {
                    if ($staffId && strcasecmp($value, $staffId) === 0) {
                        $fail('Your new password cannot be the same as your Staff ID.');
                    }
                },
            ],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $user = Auth::user();
        $user->forceFill([
            'password' => Hash::make($validated['new_password']),
            'must_change_password' => false,
        ])->save();

        session()->flash('status', 'Password updated. Welcome to COOP Software.');
        $this->redirectRoute('dashboard', navigate: true);
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();

        $this->redirect('/', navigate: true);
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.auth.force-change-password');
    }
}
