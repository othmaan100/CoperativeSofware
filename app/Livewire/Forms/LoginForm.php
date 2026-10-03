<?php

namespace App\Livewire\Forms;

use App\Models\Member;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string')]
    public string $login = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $email = $this->resolveEmail();

        if (! $email || ! Auth::attempt(['email' => $email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.login' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        $this->flagIfPasswordIsStillTheStaffId();
    }

    /**
     * Self-healing check: if the password just used to log in is literally
     * the member's Staff ID, force a password change — regardless of whether
     * the account was already flagged. This catches accounts imported before
     * this safeguard existed, not just newly imported ones.
     */
    protected function flagIfPasswordIsStillTheStaffId(): void
    {
        $user = Auth::user();
        $member = $user->member;

        if ($member && hash_equals($member->staff_id, $this->password) && ! $user->must_change_password) {
            $user->forceFill(['must_change_password' => true])->save();
        }
    }

    /**
     * Resolve the entered identifier (email or Staff ID) to the account's
     * login email. Staff ID lives on the member record, not the user, since
     * a user isn't always a member (e.g. staff-only roles).
     */
    protected function resolveEmail(): ?string
    {
        $login = trim($this->login);

        if ($login === '') {
            return null;
        }

        if (str_contains($login, '@')) {
            return $login;
        }

        return Member::query()->where('staff_id', $login)->first()?->user?->email;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->login).'|'.request()->ip());
    }
}
