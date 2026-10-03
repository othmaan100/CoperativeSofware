<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Request Withdrawal</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form wire:submit="submit" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <div>
                <x-input-label for="savings_account_id" value="Savings Account" />
                <select id="savings_account_id" wire:model.live="savings_account_id" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="">Select...</option>
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">
                            {{ $account->product->name }} — ₦{{ number_format($account->withdrawableBalance(), 2) }} available
                            @if ($account->committedWithdrawalsTotal() > 0)
                                (of ₦{{ number_format((float) $account->balance, 2) }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('savings_account_id')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="requested_amount" value="Amount to Withdraw (₦)" />
                <x-text-input id="requested_amount" wire:model.live="requested_amount" type="number" step="0.01" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('requested_amount')" class="mt-1" />
            </div>

            @if ($this->lockedVoluntaryAmount > 0)
                <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-md px-4 py-3 text-sm">
                    ₦{{ number_format($this->lockedVoluntaryAmount, 2) }} of the balance on this account came from a
                    voluntary deposit made within the last {{ (int) \App\Models\Setting::get('voluntary_deposit_lock_months', 3) }} months
                    and must remain in your account until it matures — it isn't included in the amount available above.
                </div>
            @endif

            @if (count($this->warnings) > 0)
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md px-4 py-3 text-sm space-y-1">
                    <p class="font-medium">This request may not be approved as-is:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($this->warnings as $warning)
                            <li>{{ $warning }}</li>
                        @endforeach
                    </ul>
                    <p class="text-xs">You can still submit — the Treasurer will review and may adjust the amount.</p>
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

            <div class="flex justify-end">
                <x-primary-button wire:loading.attr="disabled">Submit Request</x-primary-button>
            </div>
        </form>
    </div>
</div>
