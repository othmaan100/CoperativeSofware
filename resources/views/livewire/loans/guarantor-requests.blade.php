<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Guarantor Requests</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div>
            <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Pending Invitations</h3>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Applicant</th>
                            <th class="px-4 py-3">Loan Product</th>
                            <th class="px-4 py-3 text-right">Amount Pledged</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($invitations as $invitation)
                            <tr wire:key="inv-{{ $invitation->id }}">
                                <td class="px-4 py-3">{{ $invitation->loan->member->full_name }}</td>
                                <td class="px-4 py-3">{{ $invitation->loan->product->name }} — {{ $invitation->loan->loan_no }}</td>
                                <td class="px-4 py-3 text-right">₦{{ number_format((float) $invitation->pledged_amount, 2) }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <button wire:click="accept({{ $invitation->id }})" wire:confirm="Pledge ₦{{ number_format((float) $invitation->pledged_amount, 2) }} of your own savings as security for this loan?" class="text-emerald-600 hover:underline">Accept</button>
                                    <button wire:click="decline({{ $invitation->id }})" wire:confirm="Decline this guarantee request?" class="text-red-700 hover:underline">Decline</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No pending invitations.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-2">Your Active Guarantee Exposure</h3>
            <p class="text-xs text-gray-500 mb-2">These pledged amounts have not moved out of your savings — they would only be deducted if the borrower defaults and the grace period passes.</p>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Borrower</th>
                            <th class="px-4 py-3">Loan</th>
                            <th class="px-4 py-3 text-right">Pledged</th>
                            <th class="px-4 py-3">Loan Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($exposures as $exposure)
                            <tr wire:key="exp-{{ $exposure->id }}">
                                <td class="px-4 py-3">{{ $exposure->loan->member->full_name }}</td>
                                <td class="px-4 py-3">{{ $exposure->loan->product->name }} — {{ $exposure->loan->loan_no }}</td>
                                <td class="px-4 py-3 text-right">₦{{ number_format((float) $exposure->pledged_amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    @if ($exposure->loan->status === 'defaulted')
                                        <span class="text-red-700 font-medium">Defaulted — your pledge may be called</span>
                                    @else
                                        {{ ucfirst($exposure->loan->status) }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">You are not currently guaranteeing any loans.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
