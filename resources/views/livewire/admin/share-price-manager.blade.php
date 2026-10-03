<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Share Capital Settings</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="font-semibold">Current Share Price</h3>
                <p class="text-2xl font-bold mt-1">₦{{ number_format(\App\Models\SharePriceHistory::currentPrice(), 2) }} <span class="text-sm font-normal text-gray-500">per share</span></p>
            </div>
            <x-secondary-button wire:click="openPriceForm">Set New Price</x-secondary-button>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Price History</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr><th class="text-left py-1">Effective From</th><th class="text-right py-1">Price</th><th class="text-left py-1">Set By</th><th class="text-left py-1">Status</th></tr>
                </thead>
                <tbody>
                    @foreach ($history as $row)
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $row->effective_from->format('d M Y') }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->unit_price, 2) }}</td>
                            <td class="py-1">{{ $row->setBy?->name ?? 'System default' }}</td>
                            <td class="py-1">{{ $row->is_active ? 'Active' : 'Superseded' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Minimum Share Holding</h3>
            <p class="text-sm text-gray-500 mb-4">A member's share withdrawal can never take their holding below this floor.</p>
            <div class="flex items-end gap-3">
                <div class="flex-1 max-w-xs">
                    <x-input-label for="minimum_share_holding" value="Minimum Shares" />
                    <x-text-input id="minimum_share_holding" wire:model="minimum_share_holding" type="number" min="0" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('minimum_share_holding')" class="mt-1" />
                </div>
                <x-primary-button wire:click="saveMinimumHolding">Save</x-primary-button>
            </div>
        </div>
    </div>

    @if ($showPriceForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Set New Share Price</h3>
                <p class="text-xs text-gray-500 mb-4">Purchases and withdrawals already recorded keep the price that applied at the time they were posted.</p>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="unit_price" value="Price per Share (₦)" />
                        <x-text-input id="unit_price" wire:model="unit_price" type="number" step="0.01" min="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('unit_price')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="effective_from" value="Effective From" />
                        <x-text-input id="effective_from" wire:model="effective_from" type="date" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('effective_from')" class="mt-1" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closePriceForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="savePrice" wire:loading.attr="disabled">Save</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
