<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Financial Statements</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="font-semibold text-lg">{{ $label }}</h3>
                <p class="text-xs text-gray-500 mt-1">Derived from the existing savings, loan, share, registration-fee and dividend ledgers — not a separate general ledger.</p>
            </div>
            <div>
                <x-input-label for="startYear" value="Financial Year" />
                <select id="startYear" wire:model.live="startYear" class="mt-1 block border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm text-sm">
                    @foreach ($availableYears as $year)
                        <option value="{{ $year }}">{{ \App\Support\FinancialYear::labelFor($year) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex gap-2 text-sm">
            @foreach (['trial_balance' => 'Trial Balance', 'income_statement' => 'Income Statement', 'balance_sheet' => 'Balance Sheet'] as $key => $tabLabel)
                <button wire:click="setTab('{{ $key }}')" class="px-3 py-1.5 rounded-full border {{ $tab === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-600 border-gray-300' }}">{{ $tabLabel }}</button>
            @endforeach
        </div>

        @if ($tab === 'trial_balance')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">Trial Balance — {{ $label }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $trialBalance['balances'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $trialBalance['balances'] ? 'Balances' : 'Does not balance — please report this' }}
                    </span>
                </div>
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr><th class="text-left py-1">Account</th><th class="text-right py-1">Debit</th><th class="text-right py-1">Credit</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($trialBalance['debits'] as $row)
                            <tr class="border-b last:border-0"><td class="py-1">{{ $row['label'] }}</td><td class="py-1 text-right">₦{{ number_format($row['amount'], 2) }}</td><td class="py-1 text-right">—</td></tr>
                        @endforeach
                        @foreach ($trialBalance['credits'] as $row)
                            <tr class="border-b last:border-0"><td class="py-1">{{ $row['label'] }}</td><td class="py-1 text-right">—</td><td class="py-1 text-right">₦{{ number_format($row['amount'], 2) }}</td></tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-semibold border-t-2">
                            <td class="py-2">Total</td>
                            <td class="py-2 text-right">₦{{ number_format($trialBalance['total_debits'], 2) }}</td>
                            <td class="py-2 text-right">₦{{ number_format($trialBalance['total_credits'], 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif

        @if ($tab === 'income_statement')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-4">Income Statement — {{ $label }}</h3>
                <h4 class="text-xs uppercase text-gray-500 mb-2">Income</h4>
                <table class="w-full text-sm mb-4">
                    <tbody>
                        @foreach ($incomeStatement['income'] as $row)
                            <tr class="border-b last:border-0"><td class="py-1">{{ $row['label'] }}</td><td class="py-1 text-right">₦{{ number_format($row['amount'], 2) }}</td></tr>
                        @endforeach
                        <tr class="font-semibold border-t"><td class="py-2">Total Income</td><td class="py-2 text-right">₦{{ number_format($incomeStatement['total_income'], 2) }}</td></tr>
                    </tbody>
                </table>
                <h4 class="text-xs uppercase text-gray-500 mb-2">Expenses</h4>
                <table class="w-full text-sm mb-4">
                    <tbody>
                        @foreach ($incomeStatement['expenses'] as $row)
                            <tr class="border-b last:border-0"><td class="py-1">{{ $row['label'] }}</td><td class="py-1 text-right">₦{{ number_format($row['amount'], 2) }}</td></tr>
                        @endforeach
                        <tr class="font-semibold border-t"><td class="py-2">Total Expenses</td><td class="py-2 text-right">₦{{ number_format($incomeStatement['total_expenses'], 2) }}</td></tr>
                    </tbody>
                </table>
                <div class="flex justify-between items-center pt-2 border-t-2">
                    <span class="font-semibold">Net {{ $incomeStatement['net_income'] >= 0 ? 'Surplus' : 'Deficit' }}</span>
                    <span class="font-semibold text-lg">₦{{ number_format($incomeStatement['net_income'], 2) }}</span>
                </div>
                <p class="text-xs text-gray-500 mt-3">Share dividends are a distribution of profit, not an expense — they reduce Retained Earnings on the Balance Sheet directly, not Net Income here.</p>
            </div>
        @endif

        @if ($tab === 'balance_sheet')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-1">Balance Sheet — as of {{ $balanceSheet['as_of']->format('d M Y') }}</h3>
                <p class="text-xs text-gray-500 mb-4">"Cash & Bank" is an implied figure (not directly tracked) — reconcile it against your actual bank statement.</p>
                <h4 class="text-xs uppercase text-gray-500 mb-2">Assets</h4>
                <table class="w-full text-sm mb-4">
                    <tbody>
                        @foreach ($balanceSheet['assets'] as $row)
                            <tr class="border-b last:border-0"><td class="py-1">{{ $row['label'] }}</td><td class="py-1 text-right">₦{{ number_format($row['amount'], 2) }}</td></tr>
                        @endforeach
                        <tr class="font-semibold border-t"><td class="py-2">Total Assets</td><td class="py-2 text-right">₦{{ number_format($balanceSheet['total_assets'], 2) }}</td></tr>
                    </tbody>
                </table>
                <h4 class="text-xs uppercase text-gray-500 mb-2">Liabilities</h4>
                <table class="w-full text-sm mb-4">
                    <tbody>
                        @foreach ($balanceSheet['liabilities'] as $row)
                            <tr class="border-b last:border-0"><td class="py-1">{{ $row['label'] }}</td><td class="py-1 text-right">₦{{ number_format($row['amount'], 2) }}</td></tr>
                        @endforeach
                        <tr class="font-semibold border-t"><td class="py-2">Total Liabilities</td><td class="py-2 text-right">₦{{ number_format($balanceSheet['total_liabilities'], 2) }}</td></tr>
                    </tbody>
                </table>
                <h4 class="text-xs uppercase text-gray-500 mb-2">Equity</h4>
                <table class="w-full text-sm mb-4">
                    <tbody>
                        @foreach ($balanceSheet['equity'] as $row)
                            <tr class="border-b last:border-0"><td class="py-1">{{ $row['label'] }}</td><td class="py-1 text-right">₦{{ number_format($row['amount'], 2) }}</td></tr>
                        @endforeach
                        <tr class="font-semibold border-t"><td class="py-2">Total Equity</td><td class="py-2 text-right">₦{{ number_format($balanceSheet['total_equity'], 2) }}</td></tr>
                    </tbody>
                </table>
                <div class="flex justify-between items-center pt-2 border-t-2">
                    <span class="font-semibold">Total Liabilities + Equity</span>
                    <span class="font-semibold text-lg">₦{{ number_format($balanceSheet['total_liabilities_and_equity'], 2) }}</span>
                </div>
            </div>
        @endif
    </div>
</div>
