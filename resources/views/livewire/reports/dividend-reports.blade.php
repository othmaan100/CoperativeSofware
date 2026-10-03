<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Dividend Reports</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Period</th>
                        <th class="px-4 py-3">Dates</th>
                        <th class="px-4 py-3 text-right">Share Rate</th>
                        <th class="px-4 py-3 text-right">Savings Rate</th>
                        <th class="px-4 py-3 text-right">Total Dividend</th>
                        <th class="px-4 py-3 text-right">Total Interest</th>
                        <th class="px-4 py-3 text-right">Tracked Profit</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($periods as $period)
                        <tr wire:key="period-{{ $period->id }}">
                            <td class="px-4 py-3 font-medium">{{ $period->label }}</td>
                            <td class="px-4 py-3">{{ $period->fy_start_date->format('d M Y') }} – {{ $period->fy_end_date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->share_dividend_rate_pct !== null ? $period->share_dividend_rate_pct.'%' : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->savings_interest_rate_pct !== null ? $period->savings_interest_rate_pct.'%' : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->total_share_dividend_amount !== null ? '₦'.number_format((float) $period->total_share_dividend_amount, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->total_savings_interest_amount !== null ? '₦'.number_format((float) $period->total_savings_interest_amount, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                {{ $period->distributable_profit_snapshot !== null ? '₦'.number_format((float) $period->distributable_profit_snapshot, 2) : '—' }}
                                @if ($period->distributable_profit_snapshot !== null && $period->total_share_dividend_amount !== null && (((float) $period->total_share_dividend_amount + (float) $period->total_savings_interest_amount) > (float) $period->distributable_profit_snapshot))
                                    <div class="text-xs text-amber-600 mt-0.5">Exceeds tracked profit</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ ucfirst($period->status) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No dividend periods yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Top Recipients (All Time, Posted Only)</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr><th class="text-left py-1">Member</th><th class="text-right py-1">Total Dividend</th><th class="text-right py-1">Total Interest</th></tr>
                </thead>
                <tbody>
                    @forelse ($topRecipients as $row)
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $row->member->full_name }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->total_dividend, 2) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->total_interest, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-2 text-gray-500">No dividends posted yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
