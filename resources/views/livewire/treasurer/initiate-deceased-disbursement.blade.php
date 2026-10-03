<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Next-of-Kin Disbursement — {{ $member->full_name }}</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4 text-sm space-y-1">
            <p>Outstanding loans: {{ $member->hasOutstandingLoans() ? 'Yes — must be settled first' : 'None' }}</p>
            <p>Active guarantor obligations: {{ $member->hasActiveGuarantorObligations() ? 'Yes — must be resolved first' : 'None' }}</p>
            @if ($member->nextOfKin->isNotEmpty())
                <p>Recorded next of kin: {{ $member->nextOfKin->first()->name }} ({{ $member->nextOfKin->first()->relationship }}) — {{ $member->nextOfKin->first()->phone }}</p>
            @endif
        </div>

        <form wire:submit="submit" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <div>
                <x-input-label for="savings_account_id" value="Savings Account" />
                <select id="savings_account_id" wire:model.live="savings_account_id" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="">Select...</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->product->name }} — Balance ₦{{ number_format((float) $account->balance, 2) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('savings_account_id')" class="mt-1" />
            </div>

            @if ($this->selectedAccount)
                <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4 text-sm">
                    <p>Current Balance: <strong>₦{{ number_format((float) $this->selectedAccount->balance, 2) }}</strong></p>
                    <p class="mt-1">Payable to next of kin: <strong class="text-lg">₦{{ number_format($this->payoutAmount, 2) }}</strong></p>
                    <p class="text-xs text-gray-500 mt-1">The society's minimum balance requirement remains in the account.</p>
                </div>
            @endif

            <h3 class="font-semibold pt-2">Next of Kin Bank Details</h3>
            <div>
                <x-input-label for="bank_name" value="Bank Name" />
                <x-text-input id="bank_name" wire:model="bank_name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('bank_name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="account_number" value="Account Number" />
                <x-text-input id="account_number" wire:model="account_number" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('account_number')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="account_name" value="Account Name (Next of Kin)" />
                <x-text-input id="account_name" wire:model="account_name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('account_name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="reason" value="Note (optional)" />
                <textarea id="reason" wire:model="reason" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <div class="flex justify-end">
                <x-primary-button wire:loading.attr="disabled">Submit for Chairman Authorization</x-primary-button>
            </div>
        </form>
    </div>
</div>
