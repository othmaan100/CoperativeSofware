<?php

namespace App\Livewire\Savings;

use App\Models\Member;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RequestCompleteWithdrawal extends Component
{
    public Member $member;

    public string $savings_account_id = '';

    public string $bank_name = '';

    public string $account_number = '';

    public string $account_name = '';

    public string $reason = '';

    public bool $acknowledge = false;

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();

        abort_unless($this->member->status === 'active', 403, 'Only active members can request a complete withdrawal.');
        abort_unless(Auth::user()->can('request_withdrawal'), 403);
        abort_if(
            $this->member->withdrawalRequests()
                ->where('type', WithdrawalRequest::TYPE_COMPLETE)
                ->whereIn('status', ['pending', 'treasurer_approved', 'chairman_authorized'])
                ->exists(),
            400,
            'You already have a complete withdrawal request in progress.'
        );

        $this->account_name = $this->member->full_name;
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

    #[Computed]
    public function lockedVoluntaryAmount(): float
    {
        return $this->selectedAccount ? $this->selectedAccount->lockedVoluntaryDepositTotal() : 0.0;
    }

    protected function rules(): array
    {
        return [
            'savings_account_id' => ['required', 'exists:savings_accounts,id'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string'],
            'acknowledge' => ['accepted'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $account = $this->member->savingsAccounts()->findOrFail($validated['savings_account_id']);
        $amount = $account->maxCompleteWithdrawalAmount();

        if ($amount <= 0) {
            $this->addError('savings_account_id', 'There is no withdrawable balance above the required minimum on this account.');

            return;
        }

        WithdrawalRequest::create([
            'member_id' => $this->member->id,
            'savings_account_id' => $account->id,
            'type' => WithdrawalRequest::TYPE_COMPLETE,
            'beneficiary_type' => WithdrawalRequest::BENEFICIARY_MEMBER,
            'requested_amount' => $amount,
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'reason' => $validated['reason'] ?: null,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        $this->member->logEvent('complete_withdrawal_requested', [
            'savings_account_id' => $account->id,
            'amount' => $amount,
        ], Auth::id());

        session()->flash('status', 'Complete withdrawal request submitted for Treasurer review. Your account will be suspended once the funds are disbursed.');
        $this->redirectRoute('my-savings', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.savings.request-complete-withdrawal', [
            'accounts' => $this->member->savingsAccounts()->with('product')->get(),
        ]);
    }
}
