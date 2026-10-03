<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Statement — {{ $account->account_no }}</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-wrap gap-4 items-end">
            <div>
                <x-input-label for="from" value="From" />
                <x-text-input id="from" wire:model.live="from" type="date" class="mt-1 block w-full" />
            </div>
            <div>
                <x-input-label for="to" value="To" />
                <x-text-input id="to" wire:model.live="to" type="date" class="mt-1 block w-full" />
            </div>
            <div class="ml-auto">
                <p class="text-sm text-gray-500">Current Balance</p>
                <p class="text-xl font-bold">₦{{ number_format((float) $account->balance, 2) }}</p>
            </div>
            <x-secondary-button wire:click="downloadPdf">Download PDF</x-secondary-button>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3 text-right">Balance After</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($transactions as $txn)
                        <tr wire:key="txn-{{ $txn->id }}">
                            <td class="px-4 py-3">{{ $txn->posted_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                {{ ucwords(str_replace('_', ' ', $txn->type)) }}
                                @if ($txn->isReversed())
                                    <span class="ml-1 text-xs text-red-600">(reversed)</span>
                                @endif
                                @if ($txn->reversedTransaction)
                                    <span class="ml-1 text-xs text-gray-500">— corrects #{{ $txn->reversedTransaction->id }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $txn->description }}</td>
                            <td class="px-4 py-3 text-right {{ $txn->isCredit() ? 'text-green-700' : 'text-red-700' }}">
                                {{ $txn->isCredit() ? '+' : '-' }}₦{{ number_format((float) $txn->amount, 2) }}
                            </td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $txn->balance_after, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No transactions in this period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
