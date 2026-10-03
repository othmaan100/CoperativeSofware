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
