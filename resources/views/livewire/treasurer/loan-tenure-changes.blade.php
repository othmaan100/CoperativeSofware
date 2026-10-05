<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan Tenure Changes</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="flex flex-wrap items-center justify-between gap-3 p-4 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-semibold">Active Loans</h3>
                    <p class="text-xs text-gray-500">Request a longer tenure for a member's loan. The Chairman must approve it before the monthly repayment changes.</p>
                </div>
                <input type="search" wire:model.live.debounce.400ms="search" placeholder="Search loan no., name or staff ID" class="w-full sm:w-72 text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Loan No.</th>
                            <th class="px-4 py-3">Member</th>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3 text-right">Outstanding</th>
                            <th class="px-4 py-3 text-right">Monthly Repayment</th>
                            <th class="px-4 py-3 pl-6">Tenure</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($loans as $loan)
                            <tr wire:key="loan-{{ $loan->id }}">
                                <td class="px-4 py-3 font-medium">{{ $loan->loan_no }}</td>
                                <td class="px-4 py-3">{{ $loan->member->full_name }} <span class="text-xs text-gray-500">({{ $loan->member->staff_id }})</span></td>
                                <td class="px-4 py-3">{{ $loan->product->name }}</td>
                                <td class="px-4 py-3 text-right">₦{{ number_format((float) $loan->outstanding_balance, 2) }}</td>
                                <td class="px-4 py-3 text-right">₦{{ number_format((float) $loan->monthly_installment, 2) }}</td>
                                <td class="px-4 py-3 pl-6">{{ $loan->tenure_months }} mo.</td>
                                <td class="px-4 py-3 text-right">
                                    @if ($loan->has_pending_tenure_change)
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-amber-100 text-amber-800">Awaiting Chairman</span>
                                    @else
                                        <button wire:click="openRequest({{ $loan->id }})" class="text-emerald-600 hover:underline">Request Increase</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No active loans found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $loans->links() }}</div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-semibold">Tenure Change Requests</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Requested</th>
                            <th class="px-4 py-3">Loan No.</th>
                            <th class="px-4 py-3">Member</th>
                            <th class="px-4 py-3">Tenure</th>
                            <th class="px-4 py-3 text-right">Monthly Repayment</th>
                            <th class="px-4 py-3 pl-6">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($requests as $request)
                            <tr wire:key="request-{{ $request->id }}">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $request->requested_at->format('d M Y') }}</td>
                                <td class="px-4 py-3">{{ $request->loan->loan_no }}</td>
                                <td class="px-4 py-3">{{ $request->member->full_name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">{{ $request->current_tenure_months }} → {{ $request->requested_tenure_months }} mo.</td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    ₦{{ number_format((float) $request->current_installment, 2) }} → ₦{{ number_format((float) ($request->applied_installment ?? $request->proposed_installment), 2) }}
                                </td>
                                <td class="px-4 py-3 pl-6">
                                    @if ($request->status === 'approved')
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">Approved</span>
                                    @elseif ($request->status === 'declined')
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-800">Declined</span>
                                        @if ($request->chairman_note)
                                            <div class="text-xs text-gray-500 mt-1">{{ $request->chairman_note }}</div>
                                        @endif
                                    @else
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-amber-100 text-amber-800">Awaiting Chairman</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No tenure change requests yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $requests->links() }}</div>
        </div>
    </div>

    @if ($activeLoan)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Request Tenure Increase — {{ $activeLoan->loan_no }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activeLoan->member->full_name }}</p>

                <dl class="grid grid-cols-3 gap-3 text-sm mb-4">
                    <div><dt class="text-gray-500 text-xs">Outstanding</dt><dd class="font-medium">₦{{ number_format((float) $activeLoan->outstanding_balance, 2) }}</dd></div>
                    <div><dt class="text-gray-500 text-xs">Current Tenure</dt><dd class="font-medium">{{ $activeLoan->tenure_months }} months</dd></div>
                    <div><dt class="text-gray-500 text-xs">Monthly Repayment</dt><dd class="font-medium">₦{{ number_format((float) $activeLoan->monthly_installment, 2) }}</dd></div>
                </dl>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="new_tenure" value="New Tenure (months)" />
                        <x-text-input id="new_tenure" type="number" min="{{ $activeLoan->tenure_months + 1 }}" max="120" wire:model.live.debounce.400ms="new_tenure" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('new_tenure')" class="mt-1" />
                    </div>

                    @if ($previewInstallment !== null)
                        <div class="rounded-md bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 px-4 py-3 text-sm">
                            New monthly repayment: <strong>₦{{ number_format($previewInstallment, 2) }}</strong>
                            <span class="block text-xs text-gray-500 mt-1">The outstanding balance spread over the installments not yet paid. No extra interest is charged.</span>
                        </div>
                    @endif

                    <div>
                        <x-input-label for="reason" value="Reason" />
                        <textarea id="reason" wire:model="reason" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('reason')" class="mt-1" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeRequest">Cancel</x-secondary-button>
                    <x-primary-button wire:click="submitRequest" wire:loading.attr="disabled">Send to Chairman</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
