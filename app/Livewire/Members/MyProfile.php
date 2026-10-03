<?php

namespace App\Livewire\Members;

use App\Models\ContributionChangeRequest;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class MyProfile extends Component
{
    use WithFileUploads;

    public Member $member;

    public string $full_name = '';

    public string $date_of_birth = '';

    public string $gender = '';

    public string $ippis_number = '';

    public string $marital_status = '';

    public string $home_address = '';

    public string $phone_1 = '';

    public string $phone_2 = '';

    public string $email = '';

    public $photo;

    public string $date_of_first_appointment = '';

    public string $employment_status = '';

    public string $preferred_monthly_contribution = '';

    public string $nok_name = '';

    public string $nok_relationship = '';

    public string $nok_phone = '';

    public string $nok_address = '';

    public string $exit_reason = '';

    public bool $showContributionChangeModal = false;

    public string $new_contribution_amount = '';

    public string $contribution_change_reason = '';

    public const EDITABLE_FIELDS = [
        'full_name', 'date_of_birth', 'gender', 'ippis_number', 'marital_status',
        'home_address', 'phone_1', 'phone_2', 'email',
        'date_of_first_appointment', 'employment_status', 'preferred_monthly_contribution',
    ];

    public function mount(): void
    {
        $this->member = Auth::user()->member()->with('nextOfKin')->firstOrFail();

        foreach (self::EDITABLE_FIELDS as $field) {
            $value = $this->member->{$field};
            $this->{$field} = $value instanceof \Illuminate\Support\Carbon
                ? $value->format('Y-m-d')
                : (string) $value;
        }

        $nok = $this->member->nextOfKin->first();
        $this->nok_name = $nok->name ?? '';
        $this->nok_relationship = $nok->relationship ?? '';
        $this->nok_phone = $nok->phone ?? '';
        $this->nok_address = $nok->address ?? '';
    }

    #[Computed]
    public function pendingChangeRequests()
    {
        return $this->member->changeRequests()->where('status', 'pending')->get();
    }

    #[Computed]
    public function pendingContributionChangeRequest(): ?ContributionChangeRequest
    {
        return $this->member->contributionChangeRequests()->where('status', 'pending')->first();
    }

    protected function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'ippis_number' => ['nullable', 'string', 'max:50'],
            'marital_status' => ['required', 'in:single,married,divorced,widowed'],
            'home_address' => ['required', 'string'],
            'phone_1' => ['required', 'string', 'max:20'],
            'phone_2' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'date_of_first_appointment' => ['nullable', 'date'],
            'employment_status' => ['required', 'in:permanent,contract,casual'],
            'preferred_monthly_contribution' => ['required', 'numeric', 'min:0'],
            'nok_name' => ['required', 'string', 'max:255'],
            'nok_relationship' => ['required', 'string', 'max:100'],
            'nok_phone' => ['required', 'string', 'max:20'],
            'nok_address' => ['nullable', 'string'],
        ];
    }

    public function submitChanges(): void
    {
        $this->authorize('updateOwnProfile', $this->member);

        $validated = $this->validate();
        $user = Auth::user();
        $created = 0;

        foreach (self::EDITABLE_FIELDS as $field) {
            $current = $this->member->{$field};
            $currentNormalized = $current instanceof \Illuminate\Support\Carbon
                ? $current->format('Y-m-d')
                : (string) $current;
            $new = (string) $validated[$field];

            if ($currentNormalized !== $new) {
                $this->member->changeRequests()->create([
                    'field_name' => $field,
                    'old_value' => $currentNormalized,
                    'new_value' => $new,
                    'status' => 'pending',
                    'requested_by' => $user->id,
                    'requested_at' => now(),
                ]);
                $created++;
            }
        }

        $nok = $this->member->nextOfKin->first();
        $nokFields = [
            'nok_name' => $nok->name ?? '',
            'nok_relationship' => $nok->relationship ?? '',
            'nok_phone' => $nok->phone ?? '',
            'nok_address' => $nok->address ?? '',
        ];
        foreach ($nokFields as $field => $current) {
            $new = (string) $validated[$field];
            if ($current !== $new) {
                $this->member->changeRequests()->create([
                    'field_name' => $field,
                    'old_value' => $current,
                    'new_value' => $new,
                    'status' => 'pending',
                    'requested_by' => $user->id,
                    'requested_at' => now(),
                ]);
                $created++;
            }
        }

        if ($this->photo) {
            $path = $this->photo->store('members/photos', 'public');
            $this->member->changeRequests()->create([
                'field_name' => 'photo_path',
                'old_value' => $this->member->photo_path,
                'new_value' => $path,
                'status' => 'pending',
                'requested_by' => $user->id,
                'requested_at' => now(),
            ]);
            $this->photo = null;
            $created++;
        }

        if ($created > 0) {
            $this->member->logEvent('change_request_submitted', ['fields_changed' => $created], $user->id);
            session()->flash('status', "{$created} change(s) submitted for Secretary review.");
        } else {
            session()->flash('status', 'No changes detected.');
        }

        unset($this->pendingChangeRequests);
    }

    public function requestExit(): void
    {
        $this->authorize('requestExit', $this->member);

        $this->validate(['exit_reason' => ['required', 'string']]);

        $this->member->update([
            'exit_requested_by' => Auth::id(),
            'exit_requested_at' => now(),
            'exit_reason' => $this->exit_reason,
        ]);

        $this->member->logEvent('exit_requested', ['reason' => $this->exit_reason], Auth::id());

        session()->flash('status', 'Exit request submitted. The Treasurer will review your clearance.');
        $this->exit_reason = '';
    }

    public function openContributionChangeModal(): void
    {
        abort_unless($this->member->status === 'active', 403, 'Only active members can request a contribution change.');
        abort_if($this->pendingContributionChangeRequest, 400, 'A contribution change request is already pending review.');

        $this->showContributionChangeModal = true;
        $this->new_contribution_amount = (string) $this->member->approved_monthly_contribution;
        $this->contribution_change_reason = '';
        $this->resetErrorBag();
    }

    public function closeContributionChangeModal(): void
    {
        $this->showContributionChangeModal = false;
    }

    public function requestContributionChange(): void
    {
        abort_unless($this->member->status === 'active', 403, 'Only active members can request a contribution change.');
        abort_if($this->pendingContributionChangeRequest, 400, 'A contribution change request is already pending review.');

        $minimum = (float) Setting::get('minimum_monthly_contribution', 5000);

        $validated = $this->validate([
            'new_contribution_amount' => ['required', 'numeric', "min:{$minimum}"],
            'contribution_change_reason' => ['nullable', 'string'],
        ]);

        if (bccomp((string) $validated['new_contribution_amount'], (string) $this->member->approved_monthly_contribution, 2) === 0) {
            $this->addError('new_contribution_amount', 'This is already your current approved contribution amount.');

            return;
        }

        ContributionChangeRequest::create([
            'member_id' => $this->member->id,
            'current_amount' => $this->member->approved_monthly_contribution,
            'requested_amount' => $validated['new_contribution_amount'],
            'reason' => $validated['contribution_change_reason'] ?: null,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        $this->member->logEvent('contribution_change_requested', [
            'current_amount' => (float) $this->member->approved_monthly_contribution,
            'requested_amount' => (float) $validated['new_contribution_amount'],
        ], Auth::id());

        $this->closeContributionChangeModal();
        unset($this->pendingContributionChangeRequest);
        session()->flash('status', 'Contribution change request submitted for Treasurer review.');
    }

    public function render()
    {
        return view('livewire.members.my-profile')->layout('layouts.app');
    }
}
