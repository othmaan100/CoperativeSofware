<?php

namespace App\Livewire\Members;

use App\Models\Member;
use App\Models\NextOfKin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CompleteProfile extends Component
{
    public Member $member;

    public array $missing = [];

    public string $phone_1 = '';

    public string $email = '';

    public string $gender = '';

    public string $date_of_birth = '';

    public string $marital_status = '';

    public string $home_address = '';

    public string $nok_name = '';

    public string $nok_relationship = '';

    public string $nok_phone = '';

    public function mount(): void
    {
        $this->member = Auth::user()->member()->with('nextOfKin')->firstOrFail();

        abort_if($this->member->hasCompleteProfile(), 404);

        $this->missing = $this->member->missingProfileFields();

        $nok = $this->member->nextOfKin->first();
        $this->nok_name = $nok->name ?? '';
        $this->nok_relationship = $nok->relationship ?? '';
        $this->nok_phone = $nok->phone ?? '';
    }

    protected function rules(): array
    {
        $rules = [];

        if (in_array('phone_1', $this->missing, true)) {
            $rules['phone_1'] = ['required', 'string', 'max:20'];
        }
        if (in_array('email', $this->missing, true)) {
            $rules['email'] = ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->member->user_id)];
        }
        if (in_array('gender', $this->missing, true)) {
            $rules['gender'] = ['required', Rule::in(['male', 'female'])];
        }
        if (in_array('date_of_birth', $this->missing, true)) {
            $rules['date_of_birth'] = ['required', 'date', 'before:today'];
        }
        if (in_array('marital_status', $this->missing, true)) {
            $rules['marital_status'] = ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])];
        }
        if (in_array('home_address', $this->missing, true)) {
            $rules['home_address'] = ['required', 'string'];
        }
        if (in_array('nok_name', $this->missing, true)) {
            $rules['nok_name'] = ['required', 'string', 'max:255'];
        }
        if (in_array('nok_relationship', $this->missing, true)) {
            $rules['nok_relationship'] = ['required', 'string', 'max:100'];
        }
        if (in_array('nok_phone', $this->missing, true)) {
            $rules['nok_phone'] = ['required', 'string', 'max:20'];
        }

        return $rules;
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $memberUpdates = array_intersect_key($validated, array_flip(Member::PROFILE_COMPLETION_FIELDS));

        if ($memberUpdates) {
            $this->member->update($memberUpdates);
        }

        if (isset($validated['email'])) {
            $this->member->user->forceFill(['email' => $validated['email']])->save();
        }

        $nokUpdates = array_intersect_key($validated, array_flip(['nok_name', 'nok_relationship', 'nok_phone']));

        if ($nokUpdates) {
            $nok = $this->member->nextOfKin->first();

            $payload = [
                'name' => $nokUpdates['nok_name'] ?? $nok?->name,
                'relationship' => $nokUpdates['nok_relationship'] ?? $nok?->relationship,
                'phone' => $nokUpdates['nok_phone'] ?? $nok?->phone,
            ];

            if ($nok) {
                $nok->update($payload);
            } else {
                NextOfKin::create(array_merge(['member_id' => $this->member->id], $payload));
            }
        }

        $this->member->logEvent('profile_completed', ['fields' => array_keys($validated)], Auth::id());

        session()->flash('status', 'Thanks — your profile is now complete.');
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
        return view('livewire.members.complete-profile');
    }
}
