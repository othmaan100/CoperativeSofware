<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Reversals &amp; Corrections</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        @can('initiate_reversal')
            <form wire:submit="initiate" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
                <h3 class="font-semibold">Initiate a Reversal</h3>
                <div>
                    <x-input-label for="original_transaction_id" value="Transaction ID to reverse" />
                    <x-text-input id="original_transaction_id" wire:model.live="original_transaction_id" type="number" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('original_transaction_id')" class="mt-1" />
                </div>

                @if ($this->previewTransaction)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-3 text-sm">
                        <p><strong>{{ $this->previewTransaction->account->member->full_name }}</strong> — {{ ucwords(str_replace('_', ' ', $this->previewTransaction->type)) }}</p>
                        <p>Amount: ₦{{ number_format((float) $this->previewTransaction->amount, 2) }} on {{ $this->previewTransaction->posted_at->format('d M Y') }}</p>
                        <p class="text-gray-500">{{ $this->previewTransaction->description }}</p>
                    </div>
                @elseif ($original_transaction_id !== '')
                    <p class="text-sm text-red-600">Transaction not found.</p>
                @endif

                <div>
                    <x-input-label for="reason" value="Reason for reversal" />
                    <textarea id="reason" wire:model="reason" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('reason')" class="mt-1" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button wire:loading.attr="disabled">Submit for Chairman Authorization</x-primary-button>
                </div>
            </form>
        @endcan

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Original Txn</th>
                        <th class="px-4 py-3">Reason</th>
                        <th class="px-4 py-3">Initiated By</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($reversals as $rev)
                        <tr wire:key="rev-{{ $rev->id }}">
                            <td class="px-4 py-3">{{ $rev->originalTransaction->account->member->full_name }}</td>
                            <td class="px-4 py-3">#{{ $rev->original_transaction_id }} — ₦{{ number_format((float) $rev->originalTransaction->amount, 2) }}</td>
                            <td class="px-4 py-3 text-gray-500 max-w-[16rem] truncate">{{ $rev->reason }}</td>
                            <td class="px-4 py-3">{{ $rev->initiatedBy->name }}</td>
                            <td class="px-4 py-3">{{ ucfirst($rev->status) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @can('authorize_reversal')
                                    @if ($rev->status === 'pending')
                                        <button wire:click="openAuthorize({{ $rev->id }})" class="text-green-700 hover:underline">Authorize</button>
                                        <button wire:click="openDecline({{ $rev->id }})" class="text-red-700 hover:underline">Decline</button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No reversal requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $reversals->links() }}
    </div>

    @if ($activeId && $mode === 'authorize')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Authorize Reversal</h3>
                <p class="text-sm text-gray-500 mb-4">This will immediately post the correcting entry.</p>
                <div class="flex justify-end gap-2">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="authorize_" wire:loading.attr="disabled">Authorize &amp; Post</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeId && $mode === 'decline')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Decline Reversal</h3>
                <x-input-label for="decision_note" value="Reason" />
                <textarea id="decision_note" wire:model="decision_note" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('decision_note')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-danger-button wire:click="decline" wire:loading.attr="disabled">Confirm Decline</x-danger-button>
                </div>
            </div>
        </div>
    @endif
</div>
