<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Withdraw Shares</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form wire:submit="submit" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <p class="text-sm text-gray-500">
                You currently hold <strong>{{ $this->account?->total_shares ?? 0 }}</strong> share(s).
                You can withdraw up to <strong>{{ $this->maxWithdrawable }}</strong> share(s) while keeping the minimum holding requirement intact.
            </p>

            <div>
                <x-input-label for="shares_requested" value="Number of Shares to Withdraw" />
                <x-text-input id="shares_requested" wire:model="shares_requested" type="number" min="1" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('shares_requested')" class="mt-1" />
            </div>

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
