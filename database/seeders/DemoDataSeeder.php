<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MemberChangeRequest;
use App\Models\NextOfKin;
use App\Models\ReversalRequest;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;
use App\Models\User;
use App\Models\VoluntaryDepositIntent;
use App\Models\WithdrawalRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    protected const PASSWORD = '12345678';

    public function run(): void
    {
        $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->firstOrFail();

        // --- Staff/role demo accounts (no membership record needed) ---
        $treasurer = $this->makeUser('treasurer@fcetpcoop.local', 'Treasurer Demo', 'treasurer');
        $secretary = $this->makeUser('secretary@fcetpcoop.local', 'Secretary Demo', 'secretary');
        $chairman = $this->makeUser('chairman@fcetpcoop.local', 'Chairman Demo', 'chairman');
        $this->makeUser('exco@fcetpcoop.local', 'Exco Demo', 'exco');
        $this->makeUser('loan.officer@fcetpcoop.local', 'Loan Officer Demo', 'loan_officer');
        $this->makeUser('auditor@fcetpcoop.local', 'Auditor Demo', 'auditor');
        $this->makeUser('store.officer@fcetpcoop.local', 'Store Officer Demo', 'store_officer');

        // Bring the bootstrap Super Admin's password in line with the rest of the demo set.
        $superAdmin = User::query()->where('email', 'admin@fcetpcoop.local')->first();
        $superAdmin?->update(['password' => Hash::make(self::PASSWORD)]);

        // --- Applicant demo: a pending application awaiting Treasurer review ---
        $applicantUser = $this->makeUser('applicant@fcetpcoop.local', 'Aisha Mohammed', 'applicant');
        $this->createApplication($applicantUser, [
            'full_name' => 'Aisha Mohammed',
            'staff_id' => 'FCET-5001',
            'department' => 'Library',
            'phone_1' => '08011110001',
            'email' => 'applicant@fcetpcoop.local',
        ]);

        // --- Member demo: an active member with real savings activity ---
        $memberUser = $this->makeUser('member@fcetpcoop.local', 'Bello Grema', 'member');
        $member = $this->createApplication($memberUser, [
            'full_name' => 'Bello Grema',
            'staff_id' => 'FCET-5002',
            'department' => 'Bursary',
            'phone_1' => '08011110002',
            'email' => 'member@fcetpcoop.local',
        ]);
        $this->approve($member, $superAdmin, 6000);

        $memberAccount = SavingsAccount::openFor($member, $regular);
        $memberAccount->recordTransaction('contribution_deduction', 6000, 'Monthly contribution for 2026-07', $treasurer->id, 'DEMO-1');
        $memberAccount->recordTransaction('contribution_deduction', 6000, 'Monthly contribution for 2026-08', $treasurer->id, 'DEMO-2');
        $memberAccount->recordTransaction('contribution_deduction', 6000, 'Monthly contribution for 2026-09', $treasurer->id, 'DEMO-3');
        $memberAccount->recordTransaction('voluntary_deposit', 2000, 'Voluntary top-up', $treasurer->id, 'DEMO-4');

        // A pending change request for the Secretary to review.
        MemberChangeRequest::create([
            'member_id' => $member->id,
            'field_name' => 'phone_1',
            'old_value' => $member->phone_1,
            'new_value' => '08099990002',
            'status' => 'pending',
            'requested_by' => $memberUser->id,
            'requested_at' => now(),
        ]);

        // A pending voluntary deposit intent for the Treasurer to confirm.
        VoluntaryDepositIntent::create([
            'member_id' => $member->id,
            'savings_account_id' => $memberAccount->id,
            'amount' => 1500,
            'note' => 'Cash deposited at bank, awaiting confirmation',
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        // A pending withdrawal request for the Treasurer to review.
        WithdrawalRequest::create([
            'member_id' => $member->id,
            'savings_account_id' => $memberAccount->id,
            'requested_amount' => 3000,
            'bank_name' => 'First Bank',
            'account_number' => '3011122233',
            'account_name' => $member->full_name,
            'reason' => 'Personal emergency',
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        // --- Supporting cast: extra members (no logins) for richer reports/directory demo ---
        $extra1 = $this->approve($this->createApplication(null, [
            'full_name' => 'Fatima Usman',
            'staff_id' => 'FCET-5003',
            'department' => 'Academics',
            'phone_1' => '08011110003',
        ]), $superAdmin, 8000);
        $extra1Account = SavingsAccount::openFor($extra1, $regular);
        $extra1Account->recordTransaction('contribution_deduction', 8000, 'Monthly contribution for 2026-08', $treasurer->id, 'DEMO-5');
        $extra1Account->recordTransaction('contribution_deduction', 8000, 'Monthly contribution for 2026-09', $treasurer->id, 'DEMO-6');

        $extra2 = $this->approve($this->createApplication(null, [
            'full_name' => 'Ibrahim Sanda',
            'staff_id' => 'FCET-5004',
            'department' => 'Works Department',
            'phone_1' => '08011110004',
        ]), $superAdmin, 5000);
        $extra2Account = SavingsAccount::openFor($extra2, $regular);
        $extra2Account->recordTransaction('contribution_deduction', 5000, 'Monthly contribution for 2026-09', $treasurer->id, 'DEMO-7');

        // A withdrawal already endorsed by the Treasurer, ready for the Chairman to authorize.
        $awaitingChairman = WithdrawalRequest::create([
            'member_id' => $extra1->id,
            'savings_account_id' => $extra1Account->id,
            'requested_amount' => 4000,
            'approved_amount' => 4000,
            'bank_name' => 'Zenith Bank',
            'account_number' => '2022233344',
            'account_name' => $extra1->full_name,
            'reason' => 'School fees',
            'status' => 'treasurer_approved',
            'treasurer_reviewed_by' => $treasurer->id,
            'treasurer_reviewed_at' => now(),
            'treasurer_note' => 'Within minimum balance limit.',
            'requested_at' => now()->subDay(),
        ]);

        // A pending reversal request for the Chairman to authorize/decline.
        $wrongTransaction = $extra2Account->recordTransaction('contribution_deduction', 1000, 'Wrongly posted duplicate contribution', $treasurer->id, 'DEMO-8');
        ReversalRequest::create([
            'original_transaction_id' => $wrongTransaction->id,
            'reason' => 'Duplicate posting for the same period — needs reversal.',
            'initiated_by' => $treasurer->id,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        // A rejected application, for the Members Directory "Rejected" tab.
        $rejected = $this->createApplication(null, [
            'full_name' => 'Grema Kolo',
            'staff_id' => 'FCET-5005',
            'department' => 'Security',
            'phone_1' => '08011110005',
        ]);
        $rejected->update([
            'rejected_at' => now(),
            'rejection_reason' => 'Incomplete next of kin information.',
        ]);
        $rejected->statusHistory()->create([
            'from_status' => 'pending',
            'to_status' => 'rejected',
            'changed_by' => $treasurer->id,
            'reason' => 'Incomplete next of kin information.',
        ]);

        // A suspended member, for status-action demo.
        $suspended = $this->approve($this->createApplication(null, [
            'full_name' => 'Halima Yusuf',
            'staff_id' => 'FCET-5006',
            'department' => 'Academics',
            'phone_1' => '08011110006',
        ]), $superAdmin, 5000);
        $suspended->transitionTo('suspended', $superAdmin->id, 'Disciplinary review pending (demo record).');

        // A dormant-flagged member, for the dormancy confirmation demo.
        $dormantCandidate = $this->approve($this->createApplication(null, [
            'full_name' => 'Musa Adamu',
            'staff_id' => 'FCET-5007',
            'department' => 'Works Department',
            'phone_1' => '08011110007',
        ]), $superAdmin, 5000);
        $dormantCandidate->update(['dormant_flagged_at' => now(), 'approved_at' => now()->subMonths(7)]);
    }

    protected function makeUser(string $email, string $name, string $role): User
    {
        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make(self::PASSWORD),
                'email_verified_at' => now(),
            ]
        );

        if (! $user->hasRole($role)) {
            $user->assignRole($role);
        }

        return $user;
    }

    protected function createApplication(?User $user, array $overrides): Member
    {
        $member = Member::create(array_merge([
            'user_id' => $user?->id,
            'application_no' => Member::generateApplicationNo(),
            'full_name' => 'Demo Member',
            'date_of_birth' => '1988-01-01',
            'gender' => 'male',
            'marital_status' => 'married',
            'home_address' => 'Federal College of Education (Technical), Potiskum, Yobe State',
            'phone_1' => '08000000000',
            'email' => $user?->email,
            'department' => 'General',
            'staff_id' => 'FCET-0000',
            'employment_status' => 'permanent',
            'preferred_monthly_contribution' => 5000,
            'mode_of_deduction' => 'salary_deduction',
            'member_category' => 'regular_staff',
            'declaration_accepted' => true,
            'declaration_signed_name' => $overrides['full_name'] ?? 'Demo Member',
            'status' => 'pending',
            'applied_at' => now(),
        ], $overrides));

        NextOfKin::create([
            'member_id' => $member->id,
            'name' => 'Next of Kin for '.$member->full_name,
            'relationship' => 'Spouse',
            'phone' => '08022220000',
            'address' => 'Potiskum, Yobe State',
        ]);

        $member->statusHistory()->create([
            'from_status' => null,
            'to_status' => 'pending',
            'changed_by' => $user?->id,
            'reason' => 'Application submitted (demo record).',
        ]);

        return $member;
    }

    protected function approve(Member $member, User $approver, float $approvedContribution): Member
    {
        $member->membership_no = $member->generateMembershipNo();
        $member->approved_monthly_contribution = $approvedContribution;
        $member->approved_by = $approver->id;
        $member->approved_at = now();
        $member->application_fee_paid = true;
        $member->application_fee_paid_at = now();
        $member->save();

        $member->transitionTo('active', $approver->id, 'Application approved (demo record).');

        $member->user?->syncRoles(['member']);

        return $member->fresh();
    }
}
