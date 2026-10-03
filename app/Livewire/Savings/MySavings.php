<?php

namespace App\Livewire\Savings;

use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class MySavings extends Component
{
    use WithFileUploads;

    public Member $member;

    public bool $showDepositModal = false;

    public ?int $depositAccountId = null;

    public string $deposit_amount = '';

    public string $deposit_note = '';

    public $deposit_receipt;

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();

        // Safety net: ensure an active member always has a Regular Savings account,
        // even if it predates the auto-open-on-approval event.
        if ($this->member->status === 'active' || $this->member->status === 'suspended' || $this->member->status === 'dormant') {
            $regular = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();
            if ($regular) {
                SavingsAccount::openFor($this->member, $regular);
            }
        }
    }

    public function openDepositModal(int $accountId): void
    {
        abort_unless($this->member->status === 'active', 403, 'Only active members can log a voluntary deposit.');

        $this->showDepositModal = true;
        $this->depositAccountId = $accountId;
        $this->deposit_amount = '';
        $this->deposit_note = '';
        $this->reset(['deposit_receipt']);
    }

    public function closeDepositModal(): void
    {
        $this->showDepositModal = false;
        $this->reset(['deposit_receipt']);
    }

    public function submitDeposit(): void
    {
        abort_unless($this->member->status === 'active', 403, 'Only active members can log a voluntary deposit.');

        $validated = $this->validate([
            'deposit_amount' => ['required', 'numeric', 'min:1'],
            'deposit_note' => ['nullable', 'string'],
            'deposit_receipt' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $account = $this->member->savingsAccounts()->findOrFail($this->depositAccountId);

        $receiptPath = $this->deposit_receipt?->store('receipts/voluntary-deposits', 'local');

        $account->voluntaryDepositIntents()->create([
            'member_id' => $this->member->id,
            'amount' => $validated['deposit_amount'],
            'note' => $validated['deposit_note'] ?: null,
            'receipt_path' => $receiptPath,
            'receipt_original_filename' => $this->deposit_receipt?->getClientOriginalName(),
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        $months = (int) Setting::get('voluntary_deposit_lock_months', 3);

        $this->closeDepositModal();
        session()->flash('status', "Voluntary deposit logged. It will reflect once the Treasurer confirms receipt. Reminder: once confirmed, this deposit must remain in your account for at least {$months} months before it can be withdrawn.");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $accounts = $this->member->savingsAccounts()->with('product')->get();

        $withdrawalRequests = $this->member->withdrawalRequests()
            ->whereNotIn('status', ['disbursed', 'cancelled'])
            ->with('account.product')
            ->latest('requested_at')
            ->get();

        return view('livewire.savings.my-savings', [
            'accounts' => $accounts,
            'withdrawalRequests' => $withdrawalRequests,
            'voluntaryDepositLockMonths' => (int) Setting::get('voluntary_deposit_lock_months', 3),
        ]);
    }
}
