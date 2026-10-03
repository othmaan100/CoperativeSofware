<?php

namespace App\Livewire\Treasurer;

use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class InitiateDeceasedDisbursement extends Component
{
    public Member $member;

    public string $savings_account_id = '';

    public string $bank_name = '';

    public string $account_number = '';

    public string $account_name = '';

    public string $reason = '';

    public function mount(Member $member): void
    {
        abort_unless(Auth::user()->can('treasurer_review_withdrawal'), 403);
        abort_unless($member->status === 'deceased', 400, 'This action is only available for deceased members.');
        abort_if(
            $member->withdrawalRequests()
                ->where('type', WithdrawalRequest::TYPE_COMPLETE)
                ->where('beneficiary_type', WithdrawalRequest::BENEFICIARY_NEXT_OF_KIN)
                ->whereIn('status', ['pending', 'treasurer_approved', 'chairman_authorized'])
                ->exists(),
            400,
            'A next-of-kin disbursement is already in progress for this member.'
        );

        $this->member = $member;

        $nok = $member->nextOfKin()->first();
        if ($nok) {
            $this->account_name = $nok->name;
        }
    }

    #[Computed]
    public function selectedAccount()
    {
        if (! $this->savings_account_id) {
            return null;
        }

        return $this->member->savingsAccounts()->with('product')->find($this->savings_account_id);
    }

    #[Computed]
    public function payoutAmount(): float
    {
        return $this->selectedAccount ? $this->selectedAccount->maxCompleteWithdrawalAmount() : 0.0;
    }

    protected function rules(): array
    {
        return [
            'savings_account_id' => ['required', 'exists:savings_accounts,id'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string'],
        ];
    }

    public function submit(): void
    {
        abort_if($this->member->hasOutstandingLoans(), 400, 'Outstanding loans must be settled before disbursement.');
        abort_if($this->member->hasActiveGuarantorObligations(), 400, 'Active guarantor obligations must be resolved before disbursement.');

        $validated = $this->validate();

        $account = $this->member->savingsAccounts()->findOrFail($validated['savings_account_id']);
        $amount = $account->maxCompleteWithdrawalAmount();

        if ($amount <= 0) {
            $this->addError('savings_account_id', 'There is no withdrawable balance above the required minimum on this account.');

            return;
        }

        $treasurer = Auth::user();

        $request = WithdrawalRequest::create([
            'member_id' => $this->member->id,
            'savings_account_id' => $account->id,
            'type' => WithdrawalRequest::TYPE_COMPLETE,
            'beneficiary_type' => WithdrawalRequest::BENEFICIARY_NEXT_OF_KIN,
            'initiated_by' => $treasurer->id,
            'requested_amount' => $amount,
            'approved_amount' => $amount,
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'reason' => $validated['reason'] ?: null,
            'status' => 'treasurer_approved',
            'treasurer_reviewed_by' => $treasurer->id,
            'treasurer_reviewed_at' => now(),
            'treasurer_note' => 'Next-of-kin disbursement initiated following member\'s death.',
            'requested_at' => now(),
        ]);

        $this->member->logEvent('deceased_disbursement_initiated', [
            'withdrawal_request_id' => $request->id,
            'amount' => $amount,
            'next_of_kin' => $validated['account_name'],
        ], $treasurer->id);

        ActivityLog::record(
            action: 'savings.deceased_disbursement_initiated',
            description: "Initiated next-of-kin disbursement of ₦{$amount} for {$this->member->full_name}.",
            subject: $this->member,
            properties: ['amount' => $amount, 'next_of_kin' => $validated['account_name']],
        );

        session()->flash('status', 'Disbursement to next of kin submitted for Chairman authorization.');
        $this->redirectRoute('members.show', $this->member, navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.treasurer.initiate-deceased-disbursement', [
            'accounts' => $this->member->savingsAccounts()->with('product')->get(),
        ]);
    }
}
