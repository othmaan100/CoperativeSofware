<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Dividends &amp; Interest</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Period</th>
                        <th class="px-4 py-3 text-right">Avg. Shares (₦)</th>
                        <th class="px-4 py-3 text-right">Dividend</th>
                        <th class="px-4 py-3 text-right">Avg. Savings (₦)</th>
                        <th class="px-4 py-3 text-right">Interest</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($allocations as $allocation)
                        <tr wire:key="alloc-{{ $allocation->id }}">
                            <td class="px-4 py-3 font-medium">{{ $allocation->period->label }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $allocation->average_share_balance, 2) }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $allocation->share_dividend_amount, 2) }} <span class="text-xs text-gray-500">({{ $allocation->share_rate_applied }}%)</span></td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $allocation->average_savings_balance, 2) }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $allocation->savings_interest_amount, 2) }} <span class="text-xs text-gray-500">({{ $allocation->savings_rate_applied }}%)</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No dividends or interest posted yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
