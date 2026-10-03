<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Budget Reports</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap items-center justify-between gap-4">
            <h3 class="font-semibold text-lg">{{ $label }}</h3>
            <div>
                <x-input-label for="startYear" value="Financial Year" />
                <select id="startYear" wire:model.live="startYear" class="mt-1 block border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm text-sm">
                    @foreach ($availableYears as $year)
                        <option value="{{ $year }}">{{ \App\Support\FinancialYear::labelFor($year) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if (! $budget)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center text-gray-500 text-sm">
                No budget exists for {{ $label }}.
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">Budget vs. Actual — {{ $label }}</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ match($budget->status) {
                        'approved' => 'bg-green-100 text-green-800',
                        'pending_approval' => 'bg-yellow-100 text-yellow-800',
                        default => 'bg-gray-100 text-gray-800',
                    } }}">
                        {{ ucwords(str_replace('_', ' ', $budget->status)) }}
                    </span>
                </div>
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr>
                            <th class="text-left py-1">Category</th>
                            <th class="text-right py-1">Budgeted</th>
                            <th class="text-right py-1">Paid</th>
                            <th class="text-right py-1">Committed</th>
                            <th class="text-right py-1">Variance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($budget->lines as $line)
                            <tr class="border-t border-gray-100 dark:border-gray-700">
                                <td class="py-1.5">{{ $line->categoryLabel() }}</td>
                                <td class="py-1.5 text-right">₦{{ number_format((float) $line->budgeted_amount, 2) }}</td>
                                <td class="py-1.5 text-right">₦{{ number_format($line->paidAmount(), 2) }}</td>
                                <td class="py-1.5 text-right">₦{{ number_format($line->committedAmount(), 2) }}</td>
                                <td class="py-1.5 text-right {{ $line->variance() < 0 ? 'text-red-600 font-semibold' : '' }}">₦{{ number_format($line->variance(), 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-gray-300 dark:border-gray-600 font-semibold">
                            <td class="py-1.5">Total</td>
                            <td class="py-1.5 text-right">₦{{ number_format($budget->totalBudgeted(), 2) }}</td>
                            <td class="py-1.5 text-right">₦{{ number_format($budget->lines->sum(fn($l) => $l->paidAmount()), 2) }}</td>
                            <td class="py-1.5 text-right">₦{{ number_format($budget->lines->sum(fn($l) => $l->committedAmount()), 2) }}</td>
                            <td class="py-1.5 text-right">₦{{ number_format($budget->lines->sum(fn($l) => $l->variance()), 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <div class="p-6 pb-0">
                    <h3 class="font-semibold">Expenses — {{ $label }}</h3>
                </div>
                <table class="min-w-full text-sm mt-4">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Expense No.</th>
                            <th class="px-4 py-3">Category</th>
                            <th class="px-4 py-3">Description</th>
                            <th class="px-4 py-3 text-right">Amount</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($expenses as $expense)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $expense->expense_no }}</td>
                                <td class="px-4 py-3">{{ $expense->budgetLine->categoryLabel() }}</td>
                                <td class="px-4 py-3">{{ $expense->description }}</td>
                                <td class="px-4 py-3 text-right">₦{{ number_format((float) $expense->amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ match($expense->status) {
                                        'paid' => 'bg-green-100 text-green-800',
                                        'chairman_authorized' => 'bg-blue-100 text-blue-800',
                                        'chairman_declined' => 'bg-red-100 text-red-800',
                                        default => 'bg-yellow-100 text-yellow-800',
                                    } }}">
                                        {{ ucwords(str_replace('_', ' ', $expense->status)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No expenses logged.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
