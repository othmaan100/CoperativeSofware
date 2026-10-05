<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Pending Applications</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Application No.</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Department</th>
                        <th class="px-4 py-3">Preferred Contribution</th>
                        <th class="px-4 py-3">Fee</th>
                        <th class="px-4 py-3">Applied</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($applications as $app)
                        <tr wire:key="app-{{ $app->id }}">
                            <td class="px-4 py-3 font-medium">{{ $app->application_no }}</td>
                            <td class="px-4 py-3">{{ $app->full_name }}</td>
                            <td class="px-4 py-3">{{ $app->department }}</td>
                            <td class="px-4 py-3">₦{{ number_format((float) $app->preferred_monthly_contribution, 2) }}</td>
                            <td class="px-4 py-3">
                                @if ($app->application_fee_paid)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Paid</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Unpaid</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $app->applied_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="openApprove({{ $app->id }})" class="text-green-700 hover:underline">Approve</button>
                                <button wire:click="openReject({{ $app->id }})" class="text-red-700 hover:underline">Reject</button>
                                <a href="{{ route('members.show', $app) }}" wire:navigate class="text-gray-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No pending applications.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $applications->links() }}
    </div>

    {{-- Approve Modal --}}
    @if ($activeMember && $mode === 'approve')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Approve Application</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activeMember->application_no }} — {{ $activeMember->full_name }}</p>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="approved_monthly_contribution" value="Approved Monthly Contribution (₦)" />
                        <x-text-input id="approved_monthly_contribution" wire:model="approved_monthly_contribution" type="number" step="0.01" class="mt-1 block w-full" />
                        <p class="text-xs text-gray-500 mt-1">Preferred: ₦{{ number_format((float) $activeMember->preferred_monthly_contribution, 2) }}</p>
                        <x-input-error :messages="$errors->get('approved_monthly_contribution')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="adjustment_note" value="Note (required if amount is adjusted)" />
                        <textarea id="adjustment_note" wire:model="adjustment_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('adjustment_note')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label value="Application Fee" />
                        @if ($activeMember->application_fee_paid)
                            <p class="mt-1 text-sm text-green-700 bg-green-50 border border-green-200 rounded-md px-3 py-2">
                                Paid{{ $activeMember->application_fee_paid_at ? ' on '.$activeMember->application_fee_paid_at->format('d M Y') : '' }}
                                @if ($activeMember->application_fee_source === 'paystack')
                                    via Paystack.
                                @elseif ($activeMember->applicationFeeMarkedBy)
                                    (manually confirmed by {{ $activeMember->applicationFeeMarkedBy->name }}).
                                @else
                                    (manually confirmed).
                                @endif
                            </p>
                        @else
                            <p class="mt-1 text-sm text-red-700 bg-red-50 border border-red-200 rounded-md px-3 py-2">
                                Not yet paid (₦{{ number_format(\App\Models\ApplicationFeePayment::currentFee()) }}). The application cannot be approved until this is settled.
                            </p>

                            <label class="flex items-center gap-2 text-sm mt-2">
                                <input type="checkbox" wire:model.live="application_fee_paid" class="rounded border-gray-300 text-emerald-600 shadow-sm">
                                Confirm the fee was paid by other means (e.g. bank transfer, cash)
                            </label>
                            <x-input-error :messages="$errors->get('application_fee_paid')" class="mt-1" />

                            @if ($application_fee_paid)
                                <textarea wire:model="fee_override_note" rows="2" placeholder="How/when was it paid? (for the audit trail)" class="mt-2 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                                <x-input-error :messages="$errors->get('fee_override_note')" class="mt-1" />
                            @endif
                        @endif
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="approve" wire:loading.attr="disabled">Confirm Approval</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    {{-- Reject Modal --}}
    @if ($activeMember && $mode === 'reject')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Reject Application</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activeMember->application_no }} — {{ $activeMember->full_name }}</p>

                <x-input-label for="rejection_reason" value="Reason for rejection" />
                <textarea id="rejection_reason" wire:model="rejection_reason" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('rejection_reason')" class="mt-1" />

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-danger-button wire:click="reject" wire:loading.attr="disabled">Confirm Rejection</x-danger-button>
                </div>
            </div>
        </div>
    @endif
</div>
