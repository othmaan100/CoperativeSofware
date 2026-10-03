<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan Reports</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Interest Collected</h3>
                <p class="text-sm text-gray-500">Admin Charge</p>
                <p class="text-xl font-bold">₦{{ number_format((float) ($interestSplit->admin_total ?? 0), 2) }}</p>
                <p class="text-sm text-gray-500 mt-3">Profit (feeds Dividends)</p>
                <p class="text-xl font-bold text-emerald-700">₦{{ number_format((float) ($interestSplit->profit_total ?? 0), 2) }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Legacy vs. System-Originated</h3>
                <p class="text-sm text-gray-500">Legacy Imports</p>
                <p class="text-xl font-bold">{{ $legacyCount }}</p>
                <p class="text-sm text-gray-500 mt-3">Originated in System</p>
                <p class="text-xl font-bold">{{ $systemCount }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Flagged Loans</h3>
                <p class="text-xl font-bold text-red-700">{{ $overdue->count() }}</p>
                <p class="text-sm text-gray-500">overdue or defaulted</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Portfolio by Product (active exposure)</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr><th class="text-left py-1">Product</th><th class="text-right py-1">Loans</th><th class="text-right py-1">Disbursed</th><th class="text-right py-1">Outstanding</th></tr>
                </thead>
                <tbody>
                    @forelse ($portfolio as $row)
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $row->product }}</td>
                            <td class="py-1 text-right">{{ $row->loan_count }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->total_disbursed, 2) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->total_outstanding, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-2 text-gray-500">No active loans yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Overdue &amp; Defaulted Loans</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr><th class="text-left py-1">Member</th><th class="text-left py-1">Loan</th><th class="text-right py-1">Outstanding</th><th class="text-left py-1">Status</th><th class="text-right py-1">Days Overdue</th></tr>
                </thead>
                <tbody>
                    @forelse ($overdue as $loan)
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $loan->member->full_name }}</td>
                            <td class="py-1">{{ $loan->loan_no }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $loan->outstanding_balance, 2) }}</td>
                            <td class="py-1">{{ ucfirst($loan->status) }}</td>
                            <td class="py-1 text-right">{{ $loan->days_overdue }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-2 text-gray-500">No overdue or defaulted loans.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Guarantor Exposure</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr><th class="text-left py-1">Guarantor</th><th class="text-left py-1">Borrower</th><th class="text-left py-1">Loan</th><th class="text-right py-1">Pledged</th><th class="text-left py-1">Called?</th></tr>
                </thead>
                <tbody>
                    @forelse ($guarantorExposure as $g)
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $g->guarantorMember->full_name }}</td>
                            <td class="py-1">{{ $g->loan->member->full_name }}</td>
                            <td class="py-1">{{ $g->loan->loan_no }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $g->pledged_amount, 2) }}</td>
                            <td class="py-1">{{ $g->called_at ? 'Called '.$g->called_at->format('d M Y') : 'No' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-2 text-gray-500">No accepted guarantees yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Repayment Batch History</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr><th class="text-left py-1">Period</th><th class="text-left py-1">Status</th><th class="text-right py-1">Records</th><th class="text-right py-1">Amount</th></tr>
                </thead>
                <tbody>
                    @foreach ($batches as $batch)
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $batch->period }}</td>
                            <td class="py-1">{{ ucfirst($batch->status) }}</td>
                            <td class="py-1 text-right">{{ $batch->total_records }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $batch->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
