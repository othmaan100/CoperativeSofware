<?php

namespace App\Livewire\Shares;

use App\Models\Member;
use App\Models\ShareAccount;
use App\Models\ShareWithdrawalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RequestShareWithdrawal extends Component
{
    public Member $member;

    public string $shares_requested = '';

    public string $bank_name = '';

    public string $account_number = '';

    public string $account_name = '';

    public string $reason = '';

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();

        abort_unless($this->member->status === 'active', 403, 'Only active members can request a share withdrawal.');
        abort_unless(Auth::user()->can('request_share_withdrawal'), 403);

        $this->account_name = $this->member->full_name;
    }

    #[Computed]
    public function account(): ?ShareAccount
    {
        return $this->member->shareAccount;
    }

    #[Computed]
    public function maxWithdrawable(): int
    {
        return $this->account?->maxWithdrawableShares() ?? 0;
    }

    protected function rules(): array
    {
        return [
            'shares_requested' => ['required', 'integer', 'min:1'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        $account = $this->account;
        abort_unless($account, 400, 'You have no share account yet.');

        if ((int) $validated['shares_requested'] > $account->maxWithdrawableShares()) {
            $this->addError('shares_requested', "You can withdraw at most {$this->maxWithdrawable} share(s) right now, keeping the minimum holding intact.");

            return;
        }

        ShareWithdrawalRequest::create([
            'member_id' => $this->member->id,
            'share_account_id' => $account->id,
            'shares_requested' => $validated['shares_requested'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_name' => $validated['account_name'],
            'reason' => $validated['reason'] ?: null,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        session()->flash('status', 'Share withdrawal request submitted for Treasurer review.');
        $this->redirectRoute('my-shares', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.shares.request-share-withdrawal');
    }
}
