<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan Applications</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex flex-wrap gap-2 text-sm">
            @foreach (['pending' => 'Ready for Review', 'awaiting_guarantor' => 'Awaiting Guarantor', 'endorsed' => 'Endorsed (Chairman)', 'disbursement' => 'Awaiting Disbursement', 'history' => 'History'] as $key => $label)
                <button wire:click="setTab('{{ $key }}')" class="px-3 py-1.5 rounded-full border {{ $tab === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-600 border-gray-300' }}">{{ $label }}</button>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Loan No.</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3 text-right">Principal</th>
                        <th class="px-4 py-3 text-right">Repayable</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($loans as $loan)
                        <tr wire:key="loan-{{ $loan->id }}">
                            <td class="px-4 py-3 font-medium">{{ $loan->loan_no }}</td>
                            <td class="px-4 py-3">{{ $loan->member->full_name }}</td>
                            <td class="px-4 py-3">{{ $loan->product->name }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $loan->principal_amount, 2) }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $loan->total_repayable, 2) }}</td>
                            <td class="px-4 py-3">{{ ucwords(str_replace('_', ' ', $loan->status)) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @if ($tab === 'pending')
                                    <button wire:click="openReview({{ $loan->id }})" class="text-emerald-600 hover:underline">Review</button>
                                    <button wire:click="openReject({{ $loan->id }})" class="text-red-700 hover:underline">Reject</button>
                                @elseif ($tab === 'disbursement')
                                    <button wire:click="openDisburse({{ $loan->id }})" class="text-green-700 hover:underline">Disburse</button>
                                @endif
                                <a href="{{ route('loans.show', $loan) }}" wire:navigate class="text-gray-500 hover:underline">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No loans in this view.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $loans->links() }}
    </div>

    @if ($activeLoan && $mode === 'review')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Review Loan — {{ $activeLoan->loan_no }}</h3>
                <p class="text-sm text-gray-500 mb-4">
                    {{ $activeLoan->member->full_name }} — Principal ₦{{ number_format((float) $activeLoan->principal_amount, 2) }},
                    Total Repayable ₦{{ number_format((float) $activeLoan->total_repayable, 2) }}
                </p>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="tenure_months" value="Tenure (months, max {{ $activeLoan->product->max_tenure_months }})" />
                        <x-text-input id="tenure_months" wire:model="tenure_months" type="number" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('tenure_months')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="treasurer_note" value="Note" />
                        <textarea id="treasurer_note" wire:model="treasurer_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('treasurer_note')" class="mt-1" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="endorse" wire:loading.attr="disabled">Endorse to Chairman</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeId && $mode === 'reject')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Reject Loan Application</h3>
                <x-input-label for="treasurer_note" value="Reason" />
                <textarea id="treasurer_note" wire:model="treasurer_note" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('treasurer_note')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-danger-button wire:click="reject" wire:loading.attr="disabled">Confirm Rejection</x-danger-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeLoan && $mode === 'disburse')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Disburse Loan — {{ $activeLoan->loan_no }}</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="disbursement_method" value="Method" />
                        <select id="disbursement_method" wire:model="disbursement_method" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="disbursement_reference" value="Reference (optional)" />
                        <x-text-input id="disbursement_reference" wire:model="disbursement_reference" type="text" class="mt-1 block w-full" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="disburse" wire:confirm="Confirm disbursement? This will generate the repayment schedule." wire:loading.attr="disabled">Confirm Disbursement</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
