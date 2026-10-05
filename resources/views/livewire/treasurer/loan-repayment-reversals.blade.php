<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Excess Repayment Reversals</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        <p class="text-sm text-gray-500">
            When a repayment is more than a loan still owes, the excess is reversed off that loan and listed here. Once the
            member chooses what to do with it, process it below: applying posts it onto their chosen loan straight away; a
            refund is completed when you record the payment reference.
        </p>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <h3 class="font-semibold px-4 pt-4">Ready to Process</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Member</th>
                            <th class="px-4 py-3">From Loan</th>
                            <th class="px-4 py-3 text-right">Excess</th>
                            <th class="px-4 py-3">Member's Choice</th>
                            <th class="px-4 py-3">Chosen</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($awaitingProcessing as $reversal)
                            <tr wire:key="ready-{{ $reversal->id }}">
                                <td class="px-4 py-3">{{ $reversal->member->full_name }}<span class="block text-xs text-gray-500">{{ $reversal->member->staff_id }}</span></td>
                                <td class="px-4 py-3">{{ $reversal->loan->loan_no }}</td>
                                <td class="px-4 py-3 text-right font-semibold">₦{{ number_format((float) $reversal->amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    @if ($reversal->resolution === 'refund')
                                        Refund
                                        <span class="block text-xs text-gray-500">{{ $reversal->bank_name }} · {{ $reversal->account_number }} · {{ $reversal->account_name }}</span>
                                    @else
                                        Apply to loan {{ $reversal->targetLoan?->loan_no }}
                                        <span class="block text-xs text-gray-500">₦{{ number_format((float) $reversal->targetLoan?->outstanding_balance, 2) }} outstanding</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $reversal->chosen_at?->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-right">
                                    @if ($reversal->resolution === 'refund')
                                        <button wire:click="openRefund({{ $reversal->id }})" class="text-green-700 hover:underline">Record Refund</button>
                                    @else
                                        <button wire:click="applyToLoan({{ $reversal->id }})" wire:confirm="Apply ₦{{ number_format((float) $reversal->amount, 2) }} to loan {{ $reversal->targetLoan?->loan_no }}?" class="text-green-700 hover:underline">Apply to Loan</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Nothing waiting to be processed.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 pb-4">{{ $awaitingProcessing->links() }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h3 class="font-semibold">Waiting for Member's Choice</h3>
            <p class="text-xs text-gray-500 mb-2">The member has been notified and must choose before this can be processed.</p>
            <table class="min-w-full text-sm">
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($awaitingChoice as $reversal)
                        <tr wire:key="waiting-{{ $reversal->id }}">
                            <td class="py-2 pr-3">{{ $reversal->member->full_name }} <span class="text-xs text-gray-500">{{ $reversal->member->staff_id }}</span></td>
                            <td class="py-2 pr-3">Loan {{ $reversal->loan->loan_no }}</td>
                            <td class="py-2 pr-3 text-right">₦{{ number_format((float) $reversal->amount, 2) }}</td>
                            <td class="py-2 text-right text-xs text-gray-500">Since {{ $reversal->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td class="py-2 text-gray-500">None.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <h3 class="font-semibold mb-2">Recently Completed</h3>
            <table class="min-w-full text-sm">
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($completed as $reversal)
                        <tr wire:key="done-{{ $reversal->id }}">
                            <td class="py-2 pr-3">{{ $reversal->member->full_name }}</td>
                            <td class="py-2 pr-3">Loan {{ $reversal->loan->loan_no }}</td>
                            <td class="py-2 pr-3 text-right">₦{{ number_format((float) $reversal->amount, 2) }}</td>
                            <td class="py-2 pr-3">
                                {{ $reversal->resolution === 'refund' ? 'Refunded (ref: '.$reversal->refund_reference.')' : 'Applied to loan '.$reversal->targetLoan?->loan_no }}
                            </td>
                            <td class="py-2 text-right text-xs text-gray-500">{{ $reversal->processed_at?->format('d M Y') }} · {{ $reversal->processedBy?->name }}</td>
                        </tr>
                    @empty
                        <tr><td class="py-2 text-gray-500">None yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($refundReversal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Record Refund</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Pay ₦{{ number_format((float) $refundReversal->amount, 2) }} to {{ $refundReversal->account_name }},
                    {{ $refundReversal->bank_name }} {{ $refundReversal->account_number }}, then enter the payment reference.
                </p>
                <x-input-label for="refund_reference" value="Payment Reference" />
                <x-text-input id="refund_reference" wire:model="refund_reference" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('refund_reference')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeRefund">Cancel</x-secondary-button>
                    <x-primary-button wire:click="completeRefund" wire:loading.attr="disabled">Mark Refunded</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
