<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Budget Approvals</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <h3 class="font-semibold text-lg">Budgets Awaiting Approval</h3>

            @forelse ($pendingBudgets as $budget)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4" wire:key="budget-{{ $budget->id }}">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-medium">{{ \App\Support\FinancialYear::labelFor($budget->fy_start_year) }}</span>
                        <span class="font-semibold">₦{{ number_format($budget->totalBudgeted(), 2) }}</span>
                    </div>
                    <table class="min-w-full text-sm mb-3">
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($budget->lines as $line)
                                <tr>
                                    <td class="py-1">{{ $line->categoryLabel() }}</td>
                                    <td class="py-1 text-right">₦{{ number_format((float) $line->budgeted_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="flex justify-end gap-2">
                        <x-secondary-button wire:click="returnBudget({{ $budget->id }})" wire:confirm="Return this budget to the Treasurer for revision?">Return for Revision</x-secondary-button>
                        <x-primary-button wire:click="approveBudget({{ $budget->id }})" wire:confirm="Approve this budget?">Approve</x-primary-button>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No budgets awaiting approval.</p>
            @endforelse
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <div class="p-6 pb-0">
                <h3 class="font-semibold text-lg">Expenses Awaiting Authorization</h3>
            </div>
            <table class="min-w-full text-sm mt-4">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Expense No.</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3">Logged By</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($pendingExpenses as $expense)
                        <tr wire:key="expense-{{ $expense->id }}">
                            <td class="px-4 py-3 font-medium">{{ $expense->expense_no }}</td>
                            <td class="px-4 py-3">{{ $expense->budgetLine->categoryLabel() }}</td>
                            <td class="px-4 py-3">{{ $expense->description }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $expense->amount, 2) }}</td>
                            <td class="px-4 py-3">{{ $expense->initiatedBy->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="openDeclineForm({{ $expense->id }})" class="text-red-600 hover:underline">Decline</button>
                                <button wire:click="authorizeExpense({{ $expense->id }})" wire:confirm="Authorize {{ $expense->expense_no }}?" class="text-green-700 hover:underline font-semibold">Authorize</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No expenses awaiting authorization.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $pendingExpenses->links() }}
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <div class="p-6 pb-0 flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h3 class="font-semibold text-lg">Decision History</h3>
                    <p class="text-sm text-gray-500">Every budget approval or return and every expense authorization or decline, newest first.</p>
                </div>
                <div>
                    <x-input-label for="historyYear" value="Financial year" />
                    <select id="historyYear" wire:model.live="historyYear" class="mt-1 block border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm">
                        <option value="">All years</option>
                        @foreach ($historyYears as $year)
                            <option value="{{ $year }}">{{ \App\Support\FinancialYear::labelFor($year) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table class="min-w-full text-sm mt-4">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Decision</th>
                        <th class="px-4 py-3">Item</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3">Decided By</th>
                        <th class="px-4 py-3">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($decisions as $decision)
                        @php
                            $subject = $decision->subject;
                            [$decisionLabel, $decisionColor] = match ($decision->action) {
                                'budget.approved' => ['Budget Approved', 'bg-green-100 text-green-800'],
                                'budget.returned' => ['Budget Returned', 'bg-yellow-100 text-yellow-800'],
                                'expense.authorized' => ['Expense Authorized', 'bg-blue-100 text-blue-800'],
                                'expense.declined' => ['Expense Declined', 'bg-red-100 text-red-800'],
                                default => [ucwords(str_replace(['.', '_'], ' ', $decision->action)), 'bg-gray-100 text-gray-800'],
                            };
                            $isBudget = $subject instanceof \App\Models\Budget;
                        @endphp
                        <tr wire:key="decision-{{ $decision->id }}">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $decision->created_at->format('d M Y, g:i a') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap {{ $decisionColor }}">{{ $decisionLabel }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if ($isBudget)
                                    <span class="font-medium">{{ \App\Support\FinancialYear::labelFor($subject->fy_start_year) }} Budget</span>
                                @else
                                    <span class="font-medium">{{ $subject->expense_no }}</span>
                                    <span class="block text-xs text-gray-500">{{ $subject->budgetLine->categoryLabel() }} — {{ $subject->description }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                ₦{{ number_format($isBudget ? (float) $subject->lines->sum('budgeted_amount') : (float) $subject->amount, 2) }}
                            </td>
                            <td class="px-4 py-3">{{ $decision->causer_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400">
                                @if ($decision->action === 'expense.declined' && $subject->chairman_note)
                                    Reason: {{ $subject->chairman_note }}
                                @elseif ($decision->action === 'expense.authorized')
                                    Now: {{ ucwords(str_replace('_', ' ', $subject->status)) }}
                                @elseif ($decision->action === 'budget.returned')
                                    Sent back to the Treasurer for revision
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No decisions recorded{{ $historyYear !== '' ? ' for this financial year' : '' }} yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">
                {{ $decisions->links() }}
            </div>
        </div>
    </div>

    @if ($decliningExpenseId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Decline Expense</h3>
                <div>
                    <x-input-label for="declineNote" value="Reason" />
                    <textarea id="declineNote" wire:model="declineNote" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm"></textarea>
                    <x-input-error :messages="$errors->get('declineNote')" class="mt-1" />
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeDeclineForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="declineExpense" wire:loading.attr="disabled">Decline Expense</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
