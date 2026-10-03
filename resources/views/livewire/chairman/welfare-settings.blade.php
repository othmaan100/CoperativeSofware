<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Welfare Fund Settings</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-6">
            <div>
                <h3 class="font-semibold mb-1">Standing Welfare Levy</h3>
                <p class="text-sm text-gray-500 mb-3">The fixed amount every active member pays per collection period into the welfare fund.</p>
                <div class="flex items-end gap-3">
                    <div class="flex-1 max-w-xs">
                        <x-input-label for="welfare_levy_amount" value="Levy per Member (₦)" />
                        <x-text-input id="welfare_levy_amount" wire:model="welfare_levy_amount" type="number" step="0.01" min="0" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('welfare_levy_amount')" class="mt-1" />
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="font-semibold mb-1">Death Benefit Payout</h3>
                <p class="text-sm text-gray-500 mb-3">The fixed amount paid out for every valid death benefit claim.</p>
                <div class="flex items-end gap-3">
                    <div class="flex-1 max-w-xs">
                        <x-input-label for="death_benefit_amount" value="Payout Amount (₦)" />
                        <x-text-input id="death_benefit_amount" wire:model="death_benefit_amount" type="number" step="0.01" min="0" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('death_benefit_amount')" class="mt-1" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end border-t pt-4">
                <x-primary-button wire:click="save" wire:loading.attr="disabled">Save Settings</x-primary-button>
            </div>
        </div>
    </div>
</div>
