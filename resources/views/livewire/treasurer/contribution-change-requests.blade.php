<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Contribution Change Requests</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3 text-right">Current</th>
                        <th class="px-4 py-3 text-right">Requested</th>
                        <th class="px-4 py-3">Reason</th>
                        <th class="px-4 py-3">Requested On</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($requests as $req)
                        <tr wire:key="ccr-{{ $req->id }}">
                            <td class="px-4 py-3">
                                <a href="{{ route('members.show', $req->member) }}" wire:navigate class="text-emerald-600 hover:underline">{{ $req->member->full_name }}</a>
                            </td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $req->current_amount, 2) }}</td>
                            <td class="px-4 py-3 text-right font-medium">₦{{ number_format((float) $req->requested_amount, 2) }}</td>
                            <td class="px-4 py-3 text-gray-500 max-w-[16rem] truncate">{{ $req->reason }}</td>
                            <td class="px-4 py-3">{{ $req->requested_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="openApprove({{ $req->id }})" class="text-green-700 hover:underline">Approve</button>
                                <button wire:click="openReject({{ $req->id }})" class="text-red-700 hover:underline">Reject</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No pending contribution change requests.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $requests->links() }}
    </div>

    @if ($activeRequest && $mode === 'approve')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Approve Contribution Change</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activeRequest->member->full_name }} — current ₦{{ number_format((float) $activeRequest->current_amount, 2) }}</p>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="approved_amount" value="Approved Monthly Contribution (₦)" />
                        <x-text-input id="approved_amount" wire:model="approved_amount" type="number" step="0.01" class="mt-1 block w-full" />
                        <p class="text-xs text-gray-500 mt-1">Member requested: ₦{{ number_format((float) $activeRequest->requested_amount, 2) }}</p>
                        <x-input-error :messages="$errors->get('approved_amount')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="review_note" value="Note (required if amount is adjusted)" />
                        <textarea id="review_note" wire:model="review_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('review_note')" class="mt-1" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="approve" wire:loading.attr="disabled">Confirm Approval</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeId && $mode === 'reject')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Reject Contribution Change</h3>
                <x-input-label for="review_note" value="Reason" />
                <textarea id="review_note" wire:model="review_note" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('review_note')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-danger-button wire:click="reject" wire:loading.attr="disabled">Confirm Rejection</x-danger-button>
                </div>
            </div>
        </div>
    @endif
</div>
