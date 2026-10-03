<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan Products</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        @foreach ($products as $product)
            @php $multiplier = $product->currentMultiplier(); @endphp
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6" wire:key="product-{{ $product->id }}">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="font-semibold">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500">Code: {{ $product->code }} &middot; {{ $product->is_active ? 'Active' : 'Inactive' }}</p>
                    </div>
                    <div class="flex gap-2 text-sm">
                        @can('set_loan_interest_rates')
                            <x-secondary-button wire:click="openRates({{ $product->id }})">Edit Rates</x-secondary-button>
                        @endcan
                        @can('manage_loan_limit_multiplier')
                            <x-secondary-button wire:click="openMultiplier({{ $product->id }})">Set Multiplier</x-secondary-button>
                        @endcan
                        @can('manage_loan_products')
                            <x-secondary-button wire:click="openRules({{ $product->id }})">Edit Rules</x-secondary-button>
                        @endcan
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                    <div><p class="text-gray-500">Flat Rate</p><p class="font-semibold">{{ $product->interest_rate_flat }}% ({{ $product->interest_admin_pct }}% admin + {{ $product->interest_profit_pct }}% profit)</p></div>
                    <div><p class="text-gray-500">Max Tenure</p><p class="font-semibold">{{ $product->max_tenure_months }} months</p></div>
                    <div><p class="text-gray-500">Multiplier</p><p class="font-semibold">{{ $multiplier ? $multiplier->multiplier.'x' : 'Not set' }}</p></div>
                    <div><p class="text-gray-500">Guarantors</p><p class="font-semibold">{{ $product->requires_guarantor ? $product->min_guarantors.'–'.$product->max_guarantors : 'None' }}</p></div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($activeId && $mode === 'rates')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Edit Interest Rate Components</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="interest_admin_pct" value="Administrative Charge (%)" />
                        <x-text-input id="interest_admin_pct" wire:model="interest_admin_pct" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('interest_admin_pct')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="interest_profit_pct" value="Profit (accrues to dividends) (%)" />
                        <x-text-input id="interest_profit_pct" wire:model="interest_profit_pct" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('interest_profit_pct')" class="mt-1" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="saveRates" wire:loading.attr="disabled">Save</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeId && $mode === 'multiplier')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Set Loan Limit Multiplier</h3>
                <p class="text-xs text-gray-500 mb-4">Loans already approved keep the multiplier that was active when they were approved.</p>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="multiplier" value="Multiplier (x savings balance)" />
                        <x-text-input id="multiplier" wire:model="multiplier" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('multiplier')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="effective_from" value="Effective From" />
                        <x-text-input id="effective_from" wire:model="effective_from" type="date" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('effective_from')" class="mt-1" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="saveMultiplier" wire:loading.attr="disabled">Save</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeId && $mode === 'rules')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Edit Loan Product Rules</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="max_tenure_months" value="Max Tenure (months)" />
                        <x-text-input id="max_tenure_months" wire:model="max_tenure_months" type="number" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('max_tenure_months')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="min_membership_months" value="Min. Membership (months)" />
                        <x-text-input id="min_membership_months" wire:model="min_membership_months" type="number" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('min_membership_months')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="min_savings_balance" value="Min. Savings Balance (₦)" />
                        <x-text-input id="min_savings_balance" wire:model="min_savings_balance" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('min_savings_balance')" class="mt-1" />
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input id="requires_guarantor" wire:model="requires_guarantor" type="checkbox" class="rounded border-gray-300 text-emerald-600" />
                        <x-input-label for="requires_guarantor" value="Requires Guarantor" />
                    </div>
                    <div>
                        <x-input-label for="min_guarantors" value="Min. Guarantors" />
                        <x-text-input id="min_guarantors" wire:model="min_guarantors" type="number" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-input-label for="max_guarantors" value="Max. Guarantors" />
                        <x-text-input id="max_guarantors" wire:model="max_guarantors" type="number" class="mt-1 block w-full" />
                    </div>
                    <div class="flex items-center gap-2 mt-6">
                        <input id="is_active" wire:model="is_active" type="checkbox" class="rounded border-gray-300 text-emerald-600" />
                        <x-input-label for="is_active" value="Product Active" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="saveRules" wire:loading.attr="disabled">Save</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
