<?php

namespace App\Livewire\Savings;

use App\Models\Member;
use App\Models\Setting;
use App\Models\WithdrawalCondition;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RequestWithdrawal extends Component
{
    public Member $member;

    public string $savings_account_id = '';

    public string $requested_amount = '';

    public string $bank_name = '';

    public string $account_number = '';

    public string $account_name = '';

    public string $reason = '';

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();

        abort_unless($this->member->status === 'active', 403, 'Only active members can request a withdrawal.');
        abort_unless(Auth::user()->can('request_withdrawal'), 403);

        $this->account_name = $this->member->full_name;
    }

    #[Computed]
    public function warnings(): array
    {
        if (! $this->savings_account_id || ! is_numeric($this->requested_amount)) {
            return [];
        }

        $account = $this->member->savingsAccounts()->find($this->savings_account_id);

        if (! $account) {
            return [];
        }

        return collect(WithdrawalCondition::evaluate($account, (float) $this->requested_amount))
            ->filter(fn ($r) => ! $r['passed'])
            ->pluck('message')
            ->all();
    }

    /**
     * The still-locked voluntary-deposit amount on the currently selected
     * account, for member-facing disclosure — this is a hard rule (see
     * submit()), unlike the advisory warnings() above.
     */
    #[Computed]
    public function lockedVoluntaryAmount(): float
    {
        if (! $this->savings_account_id) {
            return 0.0;
        }

        $account = $this->member->savingsAccounts()->find($this->savings_account_id);

        return $account ? $account->lockedVoluntaryDepositTotal() : 0.0;
    }

    protected function rules(): array
    {
        return [
            'savings_account_id' => ['required', 'exists:savings_accounts,id'],
            'requested_amount' => ['required', 'numeric', 'min:1'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $account = $this->member->savingsAccounts()->findOrFail($validated['savings_account_id']);

        $withdrawable = $account->withdrawableBalance();
        if ((float) $validated['requested_amount'] > $withdrawable) {
            $months = (int) Setting::get('voluntary_deposit_lock_months', 3);
            $locked = $account->lockedVoluntaryDepositTotal();

            $this->addError(
                'requested_amount',
                "You can withdraw at most ₦".number_format($withdrawable, 2)." from this account right now. ".
                "₦".number_format($locked, 2)." from a recent voluntary deposit is still within its {$months}-month hold period and isn't withdrawable yet."
            );

            return;
        }

        WithdrawalRequest::create([
            'member_id' => $this->member->id,
            'savings_account_id' => $account->id,
            'requested_amount' => $validated['requested_amount'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'reason' => $validated['reason'] ?: null,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        session()->flash('status', 'Withdrawal request submitted for Treasurer review.');
        $this->redirectRoute('my-savings', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.savings.request-withdrawal', [
            'accounts' => $this->member->savingsAccounts()->with('product')->get(),
        ]);
    }
}
