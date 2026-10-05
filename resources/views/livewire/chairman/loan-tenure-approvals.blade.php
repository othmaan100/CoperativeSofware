<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan Tenure Approvals</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex gap-2 text-sm">
            @foreach (['pending' => 'Pending Approval', 'history' => 'History'] as $key => $label)
                <button wire:click="setTab('{{ $key }}')" class="px-3 py-1.5 rounded-full border {{ $tab === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-600 border-gray-300' }}">{{ $label }}</button>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Loan No.</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3 text-right">Outstanding</th>
                        <th class="px-4 py-3 pl-6">Tenure</th>
                        <th class="px-4 py-3 text-right">Monthly Repayment</th>
                        <th class="px-4 py-3 pl-6">Reason</th>
                        <th class="px-4 py-3 text-right">{{ $tab === 'pending' ? 'Actions' : 'Status' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($requests as $request)
                        <tr wire:key="tenure-{{ $request->id }}">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('loans.show', $request->loan) }}" wire:navigate class="hover:underline">{{ $request->loan->loan_no }}</a>
                            </td>
                            <td class="px-4 py-3">{{ $request->member->full_name }} <span class="text-xs text-gray-500">({{ $request->member->staff_id }})</span></td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $request->loan->outstanding_balance, 2) }}</td>
                            <td class="px-4 py-3 pl-6 whitespace-nowrap">{{ $request->current_tenure_months }} → {{ $request->requested_tenure_months }} mo.</td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                ₦{{ number_format((float) $request->current_installment, 2) }} → ₦{{ number_format((float) ($request->applied_installment ?? $request->proposed_installment), 2) }}
                            </td>
                            <td class="px-4 py-3 pl-6 text-gray-600 dark:text-gray-300">
                                {{ $request->reason }}
                                <div class="text-xs text-gray-400 mt-1">By {{ $request->requestedBy->name }}, {{ $request->requested_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">
                                @if ($tab === 'pending')
                                    <button wire:click="openApprove({{ $request->id }})" class="text-emerald-600 hover:underline">Approve</button>
                                    <button wire:click="openDecline({{ $request->id }})" class="text-red-700 hover:underline">Decline</button>
                                @elseif ($request->status === 'approved')
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">Approved</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-800">Declined</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No tenure change requests in this view.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $requests->links() }}
    </div>

    @if ($active && $mode === 'approve')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Approve Tenure Increase — {{ $active->loan->loan_no }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $active->member->full_name }}</p>

                <dl class="grid grid-cols-2 gap-3 text-sm mb-4">
                    <div><dt class="text-gray-500 text-xs">Tenure</dt><dd class="font-medium">{{ $active->loan->tenure_months }} → {{ $active->requested_tenure_months }} months</dd></div>
                    <div><dt class="text-gray-500 text-xs">Outstanding</dt><dd class="font-medium">₦{{ number_format((float) $active->loan->outstanding_balance, 2) }}</dd></div>
                    <div><dt class="text-gray-500 text-xs">Current Monthly Repayment</dt><dd class="font-medium">₦{{ number_format((float) $active->loan->monthly_installment, 2) }}</dd></div>
                    <div><dt class="text-gray-500 text-xs">New Monthly Repayment</dt><dd class="font-medium text-emerald-700">₦{{ number_format((float) $currentProposal, 2) }}</dd></div>
                </dl>

                @if ($currentProposal !== null && abs($currentProposal - (float) $active->proposed_installment) >= 0.01)
                    <p class="text-xs text-amber-700 mb-4">Repayments have been posted since the Treasurer's request, so the new repayment differs from the ₦{{ number_format((float) $active->proposed_installment, 2) }} first proposed.</p>
                @endif

                <x-input-label for="chairman_note" value="Note (optional)" />
                <textarea id="chairman_note" wire:model="chairman_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('chairman_note')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="approve" wire:loading.attr="disabled">Approve</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($active && $mode === 'decline')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Decline Tenure Increase — {{ $active->loan->loan_no }}</h3>
                <x-input-label for="chairman_note" value="Reason" />
                <textarea id="chairman_note" wire:model="chairman_note" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('chairman_note')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-danger-button wire:click="decline" wire:loading.attr="disabled">Confirm Decline</x-danger-button>
                </div>
            </div>
        </div>
    @endif
</div>
