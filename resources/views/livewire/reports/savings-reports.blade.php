<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Savings Reports</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold">Total Savings by Department</h3>
                    <button wire:click="exportCsv('department')" class="text-xs text-emerald-600 hover:underline">Export CSV</button>
                </div>
                <table class="w-full text-sm">
                    @foreach ($byDepartment as $row)
                        <tr class="border-b last:border-0"><td class="py-1">{{ $row->department }}</td><td class="py-1 text-right">₦{{ number_format((float) $row->total, 2) }}</td></tr>
                    @endforeach
                </table>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold">Total Savings by Product</h3>
                    <button wire:click="exportCsv('product')" class="text-xs text-emerald-600 hover:underline">Export CSV</button>
                </div>
                <table class="w-full text-sm">
                    @foreach ($byProduct as $row)
                        <tr class="border-b last:border-0"><td class="py-1">{{ $row->product }}</td><td class="py-1 text-right">₦{{ number_format((float) $row->total, 2) }}</td></tr>
                    @endforeach
                </table>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold">Top Savers</h3>
                    <button wire:click="exportCsv('top-savers')" class="text-xs text-emerald-600 hover:underline">Export CSV</button>
                </div>
                <table class="w-full text-sm">
                    @foreach ($topSavers as $account)
                        <tr class="border-b last:border-0"><td class="py-1">{{ $account->member->full_name }}</td><td class="py-1 text-right">₦{{ number_format((float) $account->balance, 2) }}</td></tr>
                    @endforeach
                </table>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold">Low-Balance Alerts</h3>
                    <button wire:click="exportCsv('low-balance')" class="text-xs text-emerald-600 hover:underline">Export CSV</button>
                </div>
                <table class="w-full text-sm">
                    @forelse ($lowBalance as $account)
                        <tr class="border-b last:border-0"><td class="py-1">{{ $account->member->full_name }}</td><td class="py-1 text-right">₦{{ number_format((float) $account->balance, 2) }}</td></tr>
                    @empty
                        <tr><td class="py-1 text-gray-500">None</td></tr>
                    @endforelse
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex flex-wrap justify-between items-center gap-3 mb-3">
                <div>
                    <h3 class="font-semibold">All Members' Contributions</h3>
                    <p class="text-xs text-gray-500">{{ number_format($contributionTotals->members) }} member(s). Reversed transactions are excluded.</p>
                </div>
                <div class="flex items-center gap-3">
                    <input type="search" wire:model.live.debounce.300ms="contributionSearch" placeholder="Search name, staff ID, IPPIS, department"
                           class="text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-md shadow-sm w-64">
                    <button wire:click="exportCsv('member-contributions')" class="text-xs text-emerald-600 hover:underline whitespace-nowrap">Export CSV</button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm whitespace-nowrap">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr>
                            <th class="text-left py-1 pr-3">Staff ID</th>
                            <th class="text-left py-1 pr-3">Member</th>
                            <th class="text-left py-1 pr-3">Date Joined</th>
                            <th class="text-right py-1 pr-3">Monthly</th>
                            <th class="text-right py-1 pr-3">Opening Bal.</th>
                            <th class="text-right py-1 pr-3">Total Contributions</th>
                            <th class="text-right py-1 pr-3">No.</th>
                            <th class="text-left py-1 pr-3">Last Month</th>
                            <th class="text-right py-1">Savings Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($memberContributions as $member)
                            <tr class="border-b last:border-0" wire:key="mc-{{ $member->id }}">
                                <td class="py-1 pr-3">{{ $member->staff_id }}</td>
                                <td class="py-1 pr-3">
                                    {{ $member->full_name }}
                                    @if ($member->status !== 'active')
                                        <span class="text-xs text-gray-500">({{ ucfirst($member->status) }})</span>
                                    @endif
                                </td>
                                <td class="py-1 pr-3">{{ $member->membership_date?->format('d M Y') ?? '—' }}</td>
                                <td class="py-1 pr-3 text-right">₦{{ number_format((float) $member->approved_monthly_contribution, 2) }}</td>
                                <td class="py-1 pr-3 text-right">₦{{ number_format((float) $member->opening_balance, 2) }}</td>
                                <td class="py-1 pr-3 text-right">₦{{ number_format((float) $member->total_contributed, 2) }}</td>
                                <td class="py-1 pr-3 text-right">{{ $member->contribution_count }}</td>
                                <td class="py-1 pr-3">{{ $member->last_period ? \Illuminate\Support\Carbon::createFromFormat('!Y-m', $member->last_period)->format('M Y') : '—' }}</td>
                                <td class="py-1 text-right">₦{{ number_format((float) $member->savings_balance, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="py-2 text-gray-500">No members found.</td></tr>
                        @endforelse
                    </tbody>
                    @if ($contributionTotals->members > 0)
                        <tfoot class="font-semibold border-t-2">
                            <tr>
                                <td class="py-2 pr-3" colspan="3">Total ({{ number_format($contributionTotals->members) }} members)</td>
                                <td class="py-2 pr-3 text-right">₦{{ number_format((float) $contributionTotals->monthly, 2) }}</td>
                                <td class="py-2 pr-3 text-right">₦{{ number_format((float) $contributionTotals->opening, 2) }}</td>
                                <td class="py-2 pr-3 text-right">₦{{ number_format((float) $contributionTotals->contributed, 2) }}</td>
                                <td class="py-2 pr-3"></td>
                                <td class="py-2 pr-3"></td>
                                <td class="py-2 text-right">₦{{ number_format((float) $contributionTotals->balance, 2) }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
            <div class="mt-3">{{ $memberContributions->links() }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold">Contribution Batch History</h3>
                <button wire:click="exportCsv('batches')" class="text-xs text-emerald-600 hover:underline">Export CSV</button>
            </div>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500"><tr><th class="text-left py-1">Period</th><th class="text-left py-1">Status</th><th class="text-right py-1">Records</th><th class="text-right py-1">Amount</th></tr></thead>
                <tbody>
                    @foreach ($batches as $batch)
                        <tr class="border-b last:border-0"><td class="py-1">{{ $batch->period }}</td><td class="py-1">{{ ucfirst($batch->status) }}</td><td class="py-1 text-right">{{ $batch->total_records }}</td><td class="py-1 text-right">₦{{ number_format((float) $batch->total_amount, 2) }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold">Withdrawal Activity</h3>
                <button wire:click="exportCsv('withdrawals')" class="text-xs text-emerald-600 hover:underline">Export CSV</button>
            </div>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500"><tr><th class="text-left py-1">Member</th><th class="text-right py-1">Requested</th><th class="text-left py-1">Status</th></tr></thead>
                <tbody>
                    @foreach ($withdrawals as $wr)
                        <tr class="border-b last:border-0"><td class="py-1">{{ $wr->member->full_name }}</td><td class="py-1 text-right">₦{{ number_format((float) $wr->requested_amount, 2) }}</td><td class="py-1">{{ ucwords(str_replace('_', ' ', $wr->status)) }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold">Reversal / Correction Log</h3>
                <button wire:click="exportCsv('reversals')" class="text-xs text-emerald-600 hover:underline">Export CSV</button>
            </div>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500"><tr><th class="text-left py-1">Txn #</th><th class="text-left py-1">Initiated By</th><th class="text-left py-1">Authorized By</th><th class="text-left py-1">Status</th></tr></thead>
                <tbody>
                    @foreach ($reversals as $rev)
                        <tr class="border-b last:border-0"><td class="py-1">#{{ $rev->original_transaction_id }}</td><td class="py-1">{{ $rev->initiatedBy->name }}</td><td class="py-1">{{ $rev->authorizedBy?->name ?? '—' }}</td><td class="py-1">{{ ucfirst($rev->status) }}</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
