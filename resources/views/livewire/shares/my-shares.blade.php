<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Share Capital</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">{{ $account?->account_no ?? 'No share account yet' }}</p>
                    <p class="text-3xl font-bold mt-1">{{ number_format($account->total_shares ?? 0) }} shares</p>
                    <p class="text-sm text-gray-500 mt-1">Worth ₦{{ number_format((float) ($account->balance ?? 0), 2) }} at cost</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Current Share Price</p>
                    <p class="text-xl font-semibold">₦{{ number_format($currentPrice, 2) }}</p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                @can('purchase_shares')
                    <x-primary-button wire:click="openPurchaseModal">Buy Shares</x-primary-button>
                @endcan
                @can('request_share_withdrawal')
                    <a href="{{ route('shares.withdraw') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm font-semibold rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Withdraw Shares
                    </a>
                @endcan
            </div>
        </div>

        @if ($pendingIntents->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-3">Pending Purchases</h3>
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr><th class="text-left py-1">Shares</th><th class="text-left py-1">Note</th><th class="text-left py-1">Logged</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingIntents as $intent)
                            <tr class="border-b last:border-0">
                                <td class="py-1">{{ $intent->shares_requested }}</td>
                                <td class="py-1 text-gray-500">{{ $intent->note }}</td>
                                <td class="py-1">{{ $intent->requested_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if ($pendingWithdrawals->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-3">Pending Withdrawals</h3>
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr><th class="text-left py-1">Shares Requested</th><th class="text-left py-1">Status</th><th class="text-left py-1">Requested</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingWithdrawals as $wr)
                            <tr class="border-b last:border-0">
                                <td class="py-1">{{ $wr->shares_requested }}</td>
                                <td class="py-1">{{ ucwords(str_replace('_', ' ', $wr->status)) }}</td>
                                <td class="py-1">{{ $wr->requested_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @if ($account)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3 text-right">Shares</th>
                            <th class="px-4 py-3 text-right">Unit Price</th>
                            <th class="px-4 py-3 text-right">Amount</th>
                            <th class="px-4 py-3 text-right">Balance After</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($account->transactions as $txn)
                            <tr wire:key="txn-{{ $txn->id }}">
                                <td class="px-4 py-3">{{ $txn->posted_at->format('d M Y') }}</td>
                                <td class="px-4 py-3">{{ ucwords(str_replace('_', ' ', $txn->type)) }}</td>
                                <td class="px-4 py-3 text-right">{{ $txn->shares_delta > 0 ? '+' : '' }}{{ $txn->shares_delta }}</td>
                                <td class="px-4 py-3 text-right">₦{{ number_format((float) $txn->unit_price_applied, 2) }}</td>
                                <td class="px-4 py-3 text-right">₦{{ number_format((float) $txn->amount, 2) }}</td>
                                <td class="px-4 py-3 text-right">{{ $txn->shares_after }} shares / ₦{{ number_format((float) $txn->balance_after, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No share transactions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if ($showPurchaseModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Buy Shares</h3>
                <p class="text-sm text-gray-500 mb-4">Current price: ₦{{ number_format($currentPrice, 2) }} per share.</p>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="shares_requested" value="Number of Shares" />
                        <x-text-input id="shares_requested" wire:model.live="shares_requested" type="number" min="1" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('shares_requested')" class="mt-1" />
                        @if (is_numeric($shares_requested) && $shares_requested > 0)
                            <p class="text-xs text-gray-500 mt-1">Total cost: ₦{{ number_format($shares_requested * $currentPrice, 2) }}</p>
                        @endif
                    </div>
                    <div>
                        <x-input-label for="purchase_note" value="Note (optional)" />
                        <textarea id="purchase_note" wire:model="purchase_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closePurchaseModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="submitPurchase" wire:loading.attr="disabled">Log Purchase</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
