<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan Repayments from Savings</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        <p class="text-sm text-gray-500">
            Approving a request immediately transfers the amount out of the member's savings balance and applies it
            to the loan — there is no separate disbursement step.
        </p>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Loan</th>
                        <th class="px-4 py-3">From Account</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3">Requested</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($requests as $request)
                        <tr wire:key="request-{{ $request->id }}">
                            <td class="px-4 py-3">{{ $request->member->full_name }}</td>
                            <td class="px-4 py-3">{{ $request->loan->product->name }} — {{ $request->loan->loan_no }}</td>
                            <td class="px-4 py-3">{{ $request->savingsAccount->product->name }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $request->amount, 2) }}</td>
                            <td class="px-4 py-3">{{ $request->requested_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="approve({{ $request->id }})" wire:confirm="Approve and transfer ₦{{ number_format((float) $request->amount, 2) }} from this member's savings to their loan?" class="text-green-700 hover:underline">Approve</button>
                                <button wire:click="openDecline({{ $request->id }})" class="text-red-700 hover:underline">Decline</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No pending savings-to-loan repayment requests.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $requests->links() }}
    </div>

    @if ($activeRequestId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Decline Request</h3>
                <x-input-label for="decline_reason" value="Reason" />
                <textarea id="decline_reason" wire:model="decline_reason" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('decline_reason')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-danger-button wire:click="decline" wire:loading.attr="disabled">Confirm Decline</x-danger-button>
                </div>
            </div>
        </div>
    @endif
</div>
