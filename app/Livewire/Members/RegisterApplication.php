<?php

namespace App\Livewire\Members;

use App\Models\Member;
use App\Models\NextOfKin;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterApplication extends Component
{
    use WithFileUploads;

    // Section A - Personal Information
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

    // Account credentials
    public string $password = '';

    public string $password_confirmation = '';

    // Section B - Employment Information
    public string $department = '';

    public string $staff_id = '';

    public string $date_of_first_appointment = '';

    public string $employment_status = '';

    public string $rank_grade = '';

    public string $staff_category = '';

    // Section C - Membership Commitment
    public string $preferred_monthly_contribution = '';

    public string $nok_name = '';

    public string $nok_relationship = '';

    public string $nok_phone = '';

    public string $nok_address = '';

    // Section D - Declaration
    public bool $declaration_accepted = false;

    public string $declaration_signed_name = '';

    protected function rules(): array
    {
        $minContribution = (float) Setting::get('minimum_monthly_contribution', 5000);

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:-18 years'],
            'gender' => ['required', 'in:male,female'],
            'ippis_number' => ['nullable', 'string', 'max:50'],
            'marital_status' => ['required', 'in:single,married,divorced,widowed'],
            'home_address' => ['required', 'string'],
            'phone_1' => ['required', 'string', 'max:20'],
            'phone_2' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'department' => ['required', 'string', 'max:255'],
            'staff_category' => ['required', 'in:senior_staff,junior_staff'],
            'staff_id' => [
                'required', 'string', 'max:50', 'unique:members,staff_id',
                function ($attribute, $value, $fail) {
                    if (! array_key_exists($this->staff_category, Member::STAFF_CATEGORIES)) {
                        return;
                    }

                    $prefix = $this->staff_category === 'senior_staff' ? 'SS/' : 'JS/';
                    if (! preg_match('/^'.preg_quote($prefix, '/').'\d+$/', $value)) {
                        $fail("Staff Number must be in the format {$prefix}<number> for ".Member::STAFF_CATEGORIES[$this->staff_category].'.');
                    }
                },
            ],
            'date_of_first_appointment' => ['nullable', 'date'],
            'employment_status' => ['required', 'in:permanent,contract,casual'],
            'rank_grade' => ['nullable', 'string', 'max:100'],

            'preferred_monthly_contribution' => ['required', 'numeric', "min:{$minContribution}"],

            'nok_name' => ['required', 'string', 'max:255'],
            'nok_relationship' => ['required', 'string', 'max:100'],
            'nok_phone' => ['required', 'string', 'max:20'],
            'nok_address' => ['nullable', 'string'],

            'declaration_accepted' => ['accepted'],
            'declaration_signed_name' => ['required', 'string', 'max:255'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $member = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
            $user->assignRole('applicant');

            $photoPath = $this->photo?->store('members/photos', 'public');

            $member = Member::create([
                'user_id' => $user->id,
                'application_no' => Member::generateApplicationNo(),
                'full_name' => $validated['full_name'],
                'date_of_birth' => $validated['date_of_birth'],
                'gender' => $validated['gender'],
                'ippis_number' => $validated['ippis_number'] ?: null,
                'marital_status' => $validated['marital_status'],
                'home_address' => $validated['home_address'],
                'phone_1' => $validated['phone_1'],
                'phone_2' => $validated['phone_2'] ?: null,
                'email' => $validated['email'],
                'photo_path' => $photoPath,
                'department' => $validated['department'],
                'staff_id' => $validated['staff_id'],
                'date_of_first_appointment' => $validated['date_of_first_appointment'] ?: null,
                'employment_status' => $validated['employment_status'],
                'rank_grade' => $validated['rank_grade'] ?: null,
                'staff_category' => $validated['staff_category'],
                'preferred_monthly_contribution' => $validated['preferred_monthly_contribution'],
                'mode_of_deduction' => 'salary_deduction',
                'member_category' => 'regular_staff',
                'declaration_accepted' => true,
                'declaration_signed_name' => $validated['declaration_signed_name'],
                'status' => 'pending',
                'applied_at' => now(),
            ]);

            NextOfKin::create([
                'member_id' => $member->id,
                'name' => $validated['nok_name'],
                'relationship' => $validated['nok_relationship'],
                'phone' => $validated['nok_phone'],
                'address' => $validated['nok_address'] ?: null,
            ]);

            $member->statusHistory()->create([
                'from_status' => null,
                'to_status' => 'pending',
                'changed_by' => $user->id,
                'reason' => 'Application submitted.',
            ]);

            $member->logEvent('application_submitted', [
                'application_no' => $member->application_no,
            ], $user->id);

            \App\Models\ActivityLog::record(
                action: 'member.application_submitted',
                description: "{$member->full_name} submitted a membership application ({$member->application_no}).",
                subject: $member,
                causerId: $user->id,
            );

            return $member;
        });

        Auth::login($member->user);

        session()->flash('status', "Application submitted successfully. Your reference number is {$member->application_no}. Please complete the application fee payment to proceed.");

        $this->redirectRoute('my-application.pay-fee', navigate: true);
    }

    public function render()
    {
        return view('livewire.members.register-application')
            ->layout('layouts.public');
    }
}
