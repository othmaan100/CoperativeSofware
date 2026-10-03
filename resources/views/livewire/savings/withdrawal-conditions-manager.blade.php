<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Withdrawal Conditions</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex justify-between items-center">
            <p class="text-sm text-gray-500">Rules are enforced at the moment a withdrawal is reviewed — changes here don't retroactively alter already-approved requests.</p>
            @if (! $editingId)
                <x-secondary-button wire:click="startCreate">Add Rule</x-secondary-button>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-1">Voluntary Deposit Hold Period</h3>
            <p class="text-sm text-gray-500 mb-4">
                Applies automatically to every savings account: a voluntary deposit cannot be withdrawn until it has
                been in the account for this many months. Compulsory contributions are never affected.
            </p>
            <div class="flex items-end gap-3">
                <div class="flex-1 max-w-xs">
                    <x-input-label for="voluntary_deposit_lock_months" value="Hold Period (months)" />
                    <x-text-input id="voluntary_deposit_lock_months" wire:model="voluntary_deposit_lock_months" type="number" min="0" max="60" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('voluntary_deposit_lock_months')" class="mt-1" />
                </div>
                <x-primary-button wire:click="saveVoluntaryDepositLockMonths">Save</x-primary-button>
            </div>
        </div>

        @if ($editingId !== null)
            <form wire:submit="save" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="savings_product_id" value="Product" />
                        <select id="savings_product_id" wire:model="savings_product_id" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">Select...</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('savings_product_id')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="rule_type" value="Rule Type" />
                        <select id="rule_type" wire:model="rule_type" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="minimum_balance">Minimum Balance (₦)</option>
                            <option value="minimum_membership_duration">Minimum Membership Duration (months)</option>
                            <option value="max_withdrawal_pct_of_balance">Max Withdrawal (% of balance)</option>
                            <option value="cooling_period">Cooling-off Period (days)</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="value" value="Value" />
                        <x-text-input id="value" wire:model="value" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('value')" class="mt-1" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" wire:model="description" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <x-secondary-button wire:click="cancel">Cancel</x-secondary-button>
                    <x-primary-button wire:loading.attr="disabled">Save Rule</x-primary-button>
                </div>
            </form>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Rule</th>
                        <th class="px-4 py-3">Last Edited By</th>
                        <th class="px-4 py-3">Active</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($conditions as $condition)
                        <tr wire:key="cond-{{ $condition->id }}">
                            <td class="px-4 py-3">{{ $condition->product->name }}</td>
                            <td class="px-4 py-3">{{ $condition->label() }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $condition->lastEditedBy?->name ?? $condition->createdBy?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $condition->is_active ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="edit({{ $condition->id }})" class="text-emerald-600 hover:underline">Edit</button>
                                <button wire:click="toggleActive({{ $condition->id }})" class="text-gray-600 hover:underline">{{ $condition->is_active ? 'Deactivate' : 'Activate' }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No rules configured.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
