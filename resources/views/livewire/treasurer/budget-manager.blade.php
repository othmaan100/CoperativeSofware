<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Budget Manager</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex items-center justify-between gap-4">
            <div>
                <x-input-label for="startYear" value="Financial Year" />
                <select id="startYear" wire:model.live="startYear" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm">
                    @foreach ($availableYears as $year)
                        <option value="{{ $year }}">{{ \App\Support\FinancialYear::labelFor($year) }}</option>
                    @endforeach
                </select>
            </div>

            @if (! $budget)
                <x-primary-button wire:click="createDraft">Create Draft Budget for {{ $label }}</x-primary-button>
            @endif
        </div>

        @if ($budget)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-lg">{{ $label }} Budget</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ match($budget->status) {
                        'approved' => 'bg-green-100 text-green-800',
                        'pending_approval' => 'bg-yellow-100 text-yellow-800',
                        default => 'bg-gray-100 text-gray-800',
                    } }}">
                        {{ ucwords(str_replace('_', ' ', $budget->status)) }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3 text-right">Budgeted</th>
                                @if ($budget->status === 'approved')
                                    <th class="px-4 py-3 text-right">Paid</th>
                                    <th class="px-4 py-3 text-right">Committed</th>
                                    <th class="px-4 py-3 text-right">Variance</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($budget->lines as $line)
                                <tr wire:key="line-{{ $line->id }}">
                                    <td class="px-4 py-3">{{ $line->categoryLabel() }}</td>
                                    <td class="px-4 py-3 text-right">
                                        @if ($budget->status === 'draft')
                                            <input type="number" step="0.01" min="0" wire:model="amounts.{{ $line->category }}" class="w-32 text-right border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm">
                                            <x-input-error :messages="$errors->get('amounts.'.$line->category)" class="mt-1" />
                                        @else
                                            ₦{{ number_format((float) $line->budgeted_amount, 2) }}
                                        @endif
                                    </td>
                                    @if ($budget->status === 'approved')
                                        <td class="px-4 py-3 text-right">₦{{ number_format($line->paidAmount(), 2) }}</td>
                                        <td class="px-4 py-3 text-right">₦{{ number_format($line->committedAmount(), 2) }}</td>
                                        <td class="px-4 py-3 text-right {{ $line->variance() < 0 ? 'text-red-600 font-semibold' : '' }}">₦{{ number_format($line->variance(), 2) }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-semibold border-t border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-3">Total</td>
                                <td class="px-4 py-3 text-right">₦{{ number_format($budget->totalBudgeted(), 2) }}</td>
                                @if ($budget->status === 'approved')
                                    <td colspan="3"></td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if ($budget->status === 'draft')
                    <div class="flex justify-end gap-2">
                        <x-secondary-button wire:click="saveDraft">Save Draft</x-secondary-button>
                        <x-primary-button wire:click="submitForApproval" wire:confirm="Submit this budget to the Chairman for approval?">Submit for Approval</x-primary-button>
                    </div>
                @elseif ($budget->status === 'pending_approval')
                    <p class="text-sm text-gray-500">Awaiting Chairman approval.</p>
                @endif
            </div>
        @endif

        @if ($budget && $budget->status === 'approved')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-lg">Expenses</h3>
                    <x-primary-button wire:click="openExpenseForm">Log Expense</x-primary-button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Expense No.</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3 text-right">Amount</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($expenses as $expense)
                                <tr wire:key="expense-{{ $expense->id }}">
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
                                    <td class="px-4 py-3 text-right">
                                        @if ($expense->status === 'chairman_authorized')
                                            <button wire:click="markPaid({{ $expense->id }})" wire:confirm="Mark {{ $expense->expense_no }} as paid?" class="text-green-700 hover:underline font-semibold">
                                                Mark Paid
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No expenses logged yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    @if ($showExpenseForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Log Expense</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="expenseBudgetLineId" value="Category" />
                        <select id="expenseBudgetLineId" wire:model="expenseBudgetLineId" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm">
                            <option value="">— Select —</option>
                            @if ($budget)
                                @foreach ($budget->lines as $line)
                                    <option value="{{ $line->id }}">{{ $line->categoryLabel() }}</option>
                                @endforeach
                            @endif
                        </select>
                        <x-input-error :messages="$errors->get('expenseBudgetLineId')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="expenseDescription" value="Description" />
                        <x-text-input id="expenseDescription" wire:model="expenseDescription" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('expenseDescription')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="expenseAmount" value="Amount (₦)" />
                        <x-text-input id="expenseAmount" wire:model="expenseAmount" type="number" step="0.01" min="0" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('expenseAmount')" class="mt-1" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeExpenseForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="logExpense" wire:loading.attr="disabled">Log Expense</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
