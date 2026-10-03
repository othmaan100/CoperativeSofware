<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Apply for a Loan</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <form wire:submit="submit" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-5">
            <div>
                <x-input-label for="loan_product_id" value="Loan Product" />
                <select id="loan_product_id" wire:model.live="loan_product_id" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="">Select a loan product</option>
                    @foreach ($this->products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->interest_rate_flat }}% flat, up to {{ $product->max_tenure_months }} months)</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('loan_product_id')" class="mt-1" />
            </div>

            @if ($this->selectedProduct)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="principal_amount" value="Principal Amount (₦)" />
                        <x-text-input id="principal_amount" wire:model.live="principal_amount" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('principal_amount')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="tenure_months" value="Tenure (months, max {{ $this->selectedProduct->max_tenure_months }})" />
                        <x-text-input id="tenure_months" wire:model="tenure_months" type="number" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('tenure_months')" class="mt-1" />
                    </div>
                </div>

                @if ($this->eligibility)
                    <div class="rounded-md px-4 py-3 text-sm {{ empty($this->eligibility['violations']) ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                        <p>Current savings balance: ₦{{ number_format($this->eligibility['savings_balance'], 2) }} &middot; Limit multiplier: {{ $this->eligibility['multiplier'] }}x &middot; Maximum eligible: ₦{{ number_format($this->eligibility['max_amount'], 2) }}</p>
                        @foreach ($this->eligibility['violations'] as $violation)
                            <p class="mt-1">{{ $violation }}</p>
                        @endforeach
                    </div>
                @endif

                @if ($this->selectedProduct->requires_guarantor)
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-4 space-y-4">
                        <h3 class="font-semibold text-sm">
                            Guarantor{{ (int) $this->selectedProduct->max_guarantors >= 2 ? 's' : '' }}
                            ({{ (int) $this->selectedProduct->min_guarantors }}
                            {{ (int) $this->selectedProduct->max_guarantors >= 2 ? '–'.$this->selectedProduct->max_guarantors : '' }} required)
                        </h3>
                        <p class="text-xs text-gray-500">Your guarantor(s) must accept the pledge in-app before this application can go to the Treasurer.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="guarantor_1_staff_id" value="Guarantor 1 — Staff ID" />
                                <x-text-input id="guarantor_1_staff_id" wire:model="guarantor_1_staff_id" type="text" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('guarantor_1_staff_id')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="guarantor_1_pledged_amount" value="Amount Pledged (₦)" />
                                <x-text-input id="guarantor_1_pledged_amount" wire:model="guarantor_1_pledged_amount" type="number" step="0.01" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('guarantor_1_pledged_amount')" class="mt-1" />
                            </div>
                        </div>

                        @if ((int) $this->selectedProduct->max_guarantors >= 2)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="guarantor_2_staff_id" value="Guarantor 2 — Staff ID (optional)" />
                                    <x-text-input id="guarantor_2_staff_id" wire:model="guarantor_2_staff_id" type="text" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('guarantor_2_staff_id')" class="mt-1" />
                                </div>
                                <div>
                                    <x-input-label for="guarantor_2_pledged_amount" value="Amount Pledged (₦)" />
                                    <x-text-input id="guarantor_2_pledged_amount" wire:model="guarantor_2_pledged_amount" type="number" step="0.01" class="mt-1 block w-full" />
                                    <x-input-error :messages="$errors->get('guarantor_2_pledged_amount')" class="mt-1" />
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif

            <div class="flex justify-end">
                <x-primary-button wire:loading.attr="disabled">Submit Application</x-primary-button>
            </div>
        </form>
    </div>
</div>
