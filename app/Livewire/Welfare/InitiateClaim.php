<?php

namespace App\Livewire\Welfare;

use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\Setting;
use App\Models\User;
use App\Models\WelfareClaim;
use App\Notifications\WelfareClaimAwaitingAuthorizationNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Livewire\Component;

class InitiateClaim extends Component
{
    public Member $member;

    public string $date_of_death = '';

    public string $beneficiary_name = '';

    public string $beneficiary_relationship = '';

    public string $beneficiary_phone = '';

    public string $bank_name = '';

    public string $account_number = '';

    public string $account_name = '';

    public function mount(Member $member): void
    {
        abort_unless(Auth::user()->can('initiate_welfare_claim'), 403);
        abort_unless($member->status === 'deceased', 400, 'A welfare claim can only be raised for a member recorded as deceased.');
        abort_if(
            $member->welfareClaims()->whereIn('status', [WelfareClaim::STATUS_PENDING, WelfareClaim::STATUS_CHAIRMAN_AUTHORIZED])->exists(),
            400,
            'A welfare claim is already in progress for this member.'
        );

        $this->member = $member;

        $nok = $member->nextOfKin()->first();
        if ($nok) {
            $this->beneficiary_name = $nok->name;
            $this->beneficiary_relationship = $nok->relationship;
            $this->beneficiary_phone = $nok->phone;
        }
    }

    protected function rules(): array
    {
        return [
            'date_of_death' => ['required', 'date', 'before_or_equal:today'],
            'beneficiary_name' => ['required', 'string', 'max:255'],
            'beneficiary_relationship' => ['required', 'string', 'max:255'],
            'beneficiary_phone' => ['required', 'string', 'max:50'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:255'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $amount = (float) Setting::get('death_benefit_amount', 0);

        $claim = WelfareClaim::create([
            'claim_no' => WelfareClaim::generateClaimNo(),
            'member_id' => $this->member->id,
            'date_of_death' => $validated['date_of_death'],
            'beneficiary_name' => $validated['beneficiary_name'],
            'beneficiary_relationship' => $validated['beneficiary_relationship'],
            'beneficiary_phone' => $validated['beneficiary_phone'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'amount' => $amount,
            'status' => WelfareClaim::STATUS_PENDING,
            'initiated_by' => Auth::id(),
        ]);

        ActivityLog::record(
            action: 'welfare.claim_raised',
            description: "Raised welfare claim {$claim->claim_no} for {$this->member->full_name} (₦".number_format($amount, 2).').',
            subject: $claim,
        );

        Notification::send(User::permission('authorize_welfare_claim')->get(), new WelfareClaimAwaitingAuthorizationNotification($claim));

        session()->flash('status', "Welfare claim {$claim->claim_no} submitted for Chairman authorization.");
        $this->redirectRoute('welfare.claims.show', $claim, navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.welfare.initiate-claim', [
            'deathBenefitAmount' => (float) Setting::get('death_benefit_amount', 0),
        ]);
    }
}
