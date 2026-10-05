<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Loans</h2>
            @can('apply_for_loan')
                <a href="{{ route('loans.apply') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-600">
                    Apply for a Loan
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        @if ($reversals->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 {{ $reversals->contains('status', \App\Models\LoanRepaymentReversal::STATUS_AWAITING_CHOICE) ? 'ring-2 ring-amber-300' : '' }}">
                <h3 class="font-semibold">Excess Repayments</h3>
                <p class="text-xs text-gray-500 mb-3">
                    When more is deducted than a loan still owes, the extra is reversed off that loan and held here.
                    You can apply it to another active loan, or have it refunded to your bank account.
                </p>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-xs uppercase text-gray-500">
                            <tr>
                                <th class="py-2 pr-3">Date</th>
                                <th class="py-2 pr-3">From Loan</th>
                                <th class="py-2 pr-3 text-right">Excess</th>
                                <th class="py-2 pr-3">Your Choice</th>
                                <th class="py-2 pr-3">Status</th>
                                <th class="py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($reversals as $reversal)
                                <tr wire:key="reversal-{{ $reversal->id }}">
                                    <td class="py-2 pr-3">{{ $reversal->created_at->format('d M Y') }}</td>
                                    <td class="py-2 pr-3">{{ $reversal->loan->loan_no }}</td>
                                    <td class="py-2 pr-3 text-right font-semibold">₦{{ number_format((float) $reversal->amount, 2) }}</td>
                                    <td class="py-2 pr-3">{{ $reversal->resolutionLabel() }}</td>
                                    <td class="py-2 pr-3">
                                        <span class="{{ match ($reversal->status) {
                                            'completed' => 'text-green-700',
                                            'awaiting_choice' => 'text-amber-700 font-semibold',
                                            default => 'text-gray-600',
                                        } }}">{{ $reversal->statusLabel() }}</span>
                                        @if ($reversal->status === 'completed' && $reversal->refund_reference)
                                            <span class="block text-xs text-gray-500">Ref: {{ $reversal->refund_reference }}</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-right">
                                        @if ($reversal->status === 'awaiting_choice')
                                            <button wire:click="openReversal({{ $reversal->id }})" class="text-emerald-600 text-sm hover:underline">Choose what to do</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @forelse ($loans as $loan)
            @php
                $badge = match ($loan->status) {
                    'closed' => 'bg-gray-200 text-gray-700',
                    'defaulted' => 'bg-red-100 text-red-800',
                    'overdue' => 'bg-amber-100 text-amber-800',
                    'active', 'disbursed' => 'bg-green-100 text-green-800',
                    'guarantor_declined', 'treasurer_rejected', 'chairman_declined' => 'bg-red-100 text-red-800',
                    default => 'bg-yellow-100 text-yellow-800',
                };
            @endphp
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6" wire:key="loan-{{ $loan->id }}">
                <div class="flex flex-wrap items-center gap-4 justify-between">
                    <div>
                        <p class="font-semibold">{{ $loan->product->name }} — {{ $loan->loan_no }}</p>
                        <p class="text-xs text-gray-500">Applied {{ $loan->applied_at?->format('d M Y') }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badge }}">{{ ucwords(str_replace('_', ' ', $loan->status)) }}</span>
                </div>

                <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 text-sm">
                    <div><p class="text-gray-500">Principal</p><p class="font-semibold">₦{{ number_format((float) $loan->principal_amount, 2) }}</p></div>
                    <div><p class="text-gray-500">Total Repayable</p><p class="font-semibold">₦{{ number_format((float) $loan->total_repayable, 2) }}</p></div>
                    <div><p class="text-gray-500">Total Paid</p><p class="font-semibold">₦{{ number_format($loan->totalPaid(), 2) }}</p></div>
                    <div><p class="text-gray-500">Outstanding</p><p class="font-semibold">₦{{ number_format((float) $loan->outstanding_balance, 2) }}</p></div>
                    <div><p class="text-gray-500">Monthly Installment</p><p class="font-semibold">₦{{ number_format((float) $loan->monthly_installment, 2) }}</p></div>
                </div>

                <div class="mt-4 flex items-center gap-4">
                    <button wire:click="toggleExpand({{ $loan->id }})" class="text-emerald-600 text-sm hover:underline">
                        {{ $expandedLoanId === $loan->id ? 'Hide' : 'View' }} repayment schedule
                    </button>
                    @if (in_array($loan->status, ['active', 'overdue', 'defaulted']))
                        <button wire:click="openRepay({{ $loan->id }})" class="text-emerald-600 text-sm hover:underline">Make a repayment</button>
                        <button wire:click="openRepayFromSavings({{ $loan->id }})" class="text-emerald-600 text-sm hover:underline">Repay from Savings</button>
                    @endif
                    <a href="{{ route('loans.show', $loan) }}" wire:navigate class="text-emerald-600 text-sm hover:underline">Details &amp; documents</a>
                </div>

                @if ($loan->repaymentIntents->isNotEmpty())
                    <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-3">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Logged Repayments</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-xs text-gray-500">
                                    <tr>
                                        <th class="py-1 pr-3 font-normal">Logged</th>
                                        <th class="py-1 pr-3 font-normal text-right">Amount</th>
                                        <th class="py-1 pr-3 font-normal">Note</th>
                                        <th class="py-1 pr-3 font-normal">Receipt</th>
                                        <th class="py-1 font-normal">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach ($loan->repaymentIntents as $intent)
                                        <tr wire:key="intent-{{ $intent->id }}">
                                            <td class="py-1.5 pr-3 whitespace-nowrap">{{ $intent->requested_at->format('d M Y') }}</td>
                                            <td class="py-1.5 pr-3 text-right whitespace-nowrap">₦{{ number_format((float) $intent->amount, 2) }}</td>
                                            <td class="py-1.5 pr-3 text-gray-600 dark:text-gray-400">{{ $intent->note ?: '—' }}</td>
                                            <td class="py-1.5 pr-3">
                                                @if ($intent->receipt_path)
                                                    <a href="{{ route('loan-repayment-intents.receipt', $intent) }}" class="text-emerald-600 hover:underline">View</a>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="py-1.5">
                                                @if ($intent->status === 'confirmed')
                                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Approved</span>
                                                    <span class="text-xs text-gray-500">{{ $intent->confirmed_at?->format('d M Y') }}</span>
                                                @elseif ($intent->status === 'declined')
                                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Declined</span>
                                                    <span class="text-xs text-gray-500">{{ $intent->confirmed_at?->format('d M Y') }}</span>
                                                    @if ($intent->decline_reason)
                                                        <span class="block text-xs text-red-700">Reason: {{ $intent->decline_reason }}</span>
                                                    @endif
                                                @else
                                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Awaiting Treasurer</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if ($expandedLoanId === $loan->id)
                    <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-4 space-y-4">
                        @if ($loan->guarantors->isNotEmpty())
                            <div>
                                <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Guarantors</p>
                                <ul class="text-sm space-y-1">
                                    @foreach ($loan->guarantors as $guarantor)
                                        <li>{{ $guarantor->guarantorMember->full_name }} — ₦{{ number_format((float) $guarantor->pledged_amount, 2) }} ({{ ucfirst($guarantor->status) }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                                    <tr>
                                        <th class="px-3 py-2">#</th>
                                        <th class="px-3 py-2">Due Date</th>
                                        <th class="px-3 py-2 text-right">Due</th>
                                        <th class="px-3 py-2 text-right">Paid</th>
                                        <th class="px-3 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse ($loan->schedules as $schedule)
                                        <tr>
                                            <td class="px-3 py-2">{{ $schedule->installment_no }}</td>
                                            <td class="px-3 py-2">{{ $schedule->due_date->format('d M Y') }}</td>
                                            <td class="px-3 py-2 text-right">₦{{ number_format((float) $schedule->amount_due, 2) }}</td>
                                            <td class="px-3 py-2 text-right">₦{{ number_format((float) $schedule->amount_paid, 2) }}</td>
                                            <td class="px-3 py-2">{{ ucwords(str_replace('_', ' ', $schedule->status)) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="px-3 py-4 text-center text-gray-500">No schedule generated yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($loan->savingsRepaymentRequests->isNotEmpty())
                            <div>
                                <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Repay-from-Savings Requests</p>
                                <ul class="text-sm space-y-1">
                                    @foreach ($loan->savingsRepaymentRequests as $request)
                                        <li class="flex justify-between border-b last:border-0 border-gray-100 dark:border-gray-700 py-1">
                                            <span>₦{{ number_format((float) $request->amount, 2) }} — {{ $request->requested_at->format('d M Y') }}</span>
                                            <span class="{{ match($request->status) {
                                                'approved' => 'text-green-700',
                                                'declined' => 'text-red-700',
                                                default => 'text-gray-500',
                                            } }}">{{ ucfirst($request->status) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center text-gray-500">
                You have no loan applications yet.
            </div>
        @endforelse
    </div>

    @if ($repayLoanId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Log a Repayment</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="repay_amount" value="Amount (₦)" />
                        <x-text-input id="repay_amount" wire:model="repay_amount" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('repay_amount')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="repay_note" value="Note (optional)" />
                        <textarea id="repay_note" wire:model="repay_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div>
                        <x-input-label for="repay_receipt" value="Receipt (optional)" />
                        <input id="repay_receipt" wire:model="repay_receipt" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm" />
                        <p class="text-xs text-gray-500 mt-1">Attach a photo or PDF of your teller/deposit slip, if you have one. JPG, PNG or PDF, max 5MB.</p>
                        <x-input-error :messages="$errors->get('repay_receipt')" class="mt-1" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeRepay">Cancel</x-secondary-button>
                    <x-primary-button wire:click="submitRepayment" wire:loading.attr="disabled">Log Repayment</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($repayFromSavingsLoanId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Repay from Savings</h3>
                <p class="text-xs text-gray-500 mb-4">
                    This transfers money directly out of your savings balance to pay down this loan — no deposit
                    needed. You can't request more than your withdrawable savings balance, or more than the loan
                    still owes.
                </p>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="repay_from_savings_account_id" value="Savings Account" />
                        <select id="repay_from_savings_account_id" wire:model="repay_from_savings_account_id" class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="">Select...</option>
                            @foreach ($savingsAccounts as $account)
                                <option value="{{ $account->id }}">{{ $account->product->name }} — ₦{{ number_format($account->withdrawableBalance(), 2) }} withdrawable</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('repay_from_savings_account_id')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="repay_from_savings_amount" value="Amount (₦)" />
                        <x-text-input id="repay_from_savings_amount" wire:model="repay_from_savings_amount" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('repay_from_savings_amount')" class="mt-1" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeRepayFromSavings">Cancel</x-secondary-button>
                    <x-primary-button wire:click="submitRepayFromSavings" wire:loading.attr="disabled">Submit Request</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeReversal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Excess of ₦{{ number_format((float) $activeReversal->amount, 2) }}</h3>
                <p class="text-xs text-gray-500 mb-4">From loan {{ $activeReversal->loan->loan_no }}. The Treasurer will process your choice.</p>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="flex items-start gap-2 text-sm {{ $transferLoans->isEmpty() ? 'opacity-50' : '' }}">
                            <input type="radio" wire:model.live="reversal_action" value="apply_to_loan" @disabled($transferLoans->isEmpty()) class="mt-0.5 text-emerald-600">
                            <span>
                                Apply it to another active loan
                                @if ($transferLoans->isEmpty())
                                    <span class="block text-xs text-gray-500">You have no other active loan.</span>
                                @endif
                            </span>
                        </label>
                        <label class="flex items-start gap-2 text-sm">
                            <input type="radio" wire:model.live="reversal_action" value="refund" class="mt-0.5 text-emerald-600">
                            <span>Refund it to my bank account</span>
                        </label>
                        <x-input-error :messages="$errors->get('reversal_action')" class="mt-1" />
                    </div>

                    @if ($reversal_action === 'apply_to_loan')
                        <div>
                            <x-input-label for="reversal_target_loan_id" value="Loan to apply it to" />
                            <select id="reversal_target_loan_id" wire:model="reversal_target_loan_id" class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">Select...</option>
                                @foreach ($transferLoans as $transferLoan)
                                    <option value="{{ $transferLoan->id }}">{{ $transferLoan->loan_no }} — ₦{{ number_format((float) $transferLoan->outstanding_balance, 2) }} outstanding</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('reversal_target_loan_id')" class="mt-1" />
                        </div>
                    @elseif ($reversal_action === 'refund')
                        <div>
                            <x-input-label for="refund_bank_name" value="Bank Name" />
                            <x-text-input id="refund_bank_name" wire:model="refund_bank_name" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('refund_bank_name')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="refund_account_number" value="Account Number" />
                            <x-text-input id="refund_account_number" wire:model="refund_account_number" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('refund_account_number')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="refund_account_name" value="Account Name" />
                            <x-text-input id="refund_account_name" wire:model="refund_account_name" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('refund_account_name')" class="mt-1" />
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeReversal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="submitReversalChoice" wire:loading.attr="disabled">Submit</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
