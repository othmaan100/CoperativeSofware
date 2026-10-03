<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Share Capital Reports</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Total Shares Outstanding</h3>
                <p class="text-2xl font-bold">{{ number_format((int) ($totals->total_shares ?? 0)) }}</p>
                <p class="text-sm text-gray-500 mt-1">Across {{ $totals->accounts ?? 0 }} account(s)</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Total Share Capital</h3>
                <p class="text-2xl font-bold">₦{{ number_format((float) ($totals->total_balance ?? 0), 2) }}</p>
                <p class="text-sm text-gray-500 mt-1">Recorded at cost (price when purchased)</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Current Share Price</h3>
                <p class="text-2xl font-bold">₦{{ number_format($currentPrice, 2) }}</p>
                <p class="text-sm text-gray-500 mt-1">Applies to new purchases</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Top Shareholders</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr><th class="text-left py-1">Member</th><th class="text-right py-1">Shares</th><th class="text-right py-1">Balance (at cost)</th></tr>
                </thead>
                <tbody>
                    @forelse ($topShareholders as $account)
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $account->member->full_name }}</td>
                            <td class="py-1 text-right">{{ number_format($account->total_shares) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $account->balance, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-2 text-gray-500">No shares purchased yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
