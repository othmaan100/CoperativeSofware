<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Request Complete Withdrawal</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-md px-4 py-3 text-sm mb-6">
            A complete withdrawal pays out the maximum amount available on the selected account (your balance minus
            the society's required minimum balance). Once the Treasurer and Chairman approve and the funds are
            disbursed, <strong>your membership account will be suspended.</strong>
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
                    <p class="mt-1">You will receive: <strong class="text-lg">₦{{ number_format($this->payoutAmount, 2) }}</strong></p>
                    <p class="text-xs text-gray-500 mt-1">The society's minimum balance requirement remains in the account.</p>
                    @if ($this->lockedVoluntaryAmount > 0)
                        <p class="text-xs text-blue-600 mt-1">₦{{ number_format($this->lockedVoluntaryAmount, 2) }} from a recent voluntary deposit is still within its hold period and also remains in the account.</p>
                    @endif
                </div>
            @endif

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
                <x-input-label for="account_name" value="Account Name" />
                <x-text-input id="account_name" wire:model="account_name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('account_name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="reason" value="Reason (optional)" />
                <textarea id="reason" wire:model="reason" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <label class="flex items-start gap-2">
                <input type="checkbox" wire:model="acknowledge" class="mt-1 rounded border-gray-300 text-emerald-600 shadow-sm">
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    I understand this is a complete withdrawal and my membership account will be suspended once disbursed.
                </span>
            </label>
            <x-input-error :messages="$errors->get('acknowledge')" class="mt-1" />

            <div class="flex justify-end">
                <x-danger-button wire:loading.attr="disabled">Submit Complete Withdrawal Request</x-danger-button>
            </div>
        </form>
    </div>
</div>
