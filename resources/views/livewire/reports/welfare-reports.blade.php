<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Welfare Fund Reports</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Fund Balance</p>
                <p class="text-2xl font-bold mt-1">₦{{ number_format($balance, 2) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Total Levies Collected</p>
                <p class="text-2xl font-bold mt-1">₦{{ number_format($totalCollected, 2) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Total Benefits Paid</p>
                <p class="text-2xl font-bold mt-1">₦{{ number_format($totalDisbursed, 2) }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Claims by Status</h3>
            <div class="flex flex-wrap gap-4 text-sm">
                @forelse (['pending', 'chairman_authorized', 'chairman_declined', 'disbursed'] as $status)
                    <div class="px-3 py-2 rounded-md bg-gray-50 dark:bg-gray-700">
                        <span class="font-semibold">{{ $claimCounts[$status] ?? 0 }}</span>
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <div class="p-6 pb-0">
                <h3 class="font-semibold">Fund Transaction History</h3>
            </div>
            <table class="min-w-full text-sm mt-4">
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
                        <tr>
                            <td class="px-4 py-3">{{ $txn->posted_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $txn->type === 'levy' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($txn->type) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $txn->description }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $txn->amount, 2) }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $txn->balance_after, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No fund activity yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
