<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Share Withdrawal Requests</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex gap-2 text-sm">
            @foreach (['pending' => 'Pending Review', 'disbursement' => 'Awaiting Disbursement', 'history' => 'History'] as $key => $label)
                <button wire:click="setTab('{{ $key }}')" class="px-3 py-1.5 rounded-full border {{ $tab === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-600 border-gray-300' }}">{{ $label }}</button>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Account</th>
                        <th class="px-4 py-3 text-right">Requested</th>
                        <th class="px-4 py-3 text-right">Approved</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($requests as $req)
                        <tr wire:key="wd-{{ $req->id }}">
                            <td class="px-4 py-3">{{ $req->member->full_name }}</td>
                            <td class="px-4 py-3">{{ $req->account->account_no }}</td>
                            <td class="px-4 py-3 text-right">{{ $req->shares_requested }} shares</td>
                            <td class="px-4 py-3 text-right">{{ $req->shares_approved ? $req->shares_approved.' shares' : '—' }}</td>
                            <td class="px-4 py-3">{{ ucwords(str_replace('_', ' ', $req->status)) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @if ($tab === 'pending')
                                    <button wire:click="openReview({{ $req->id }})" class="text-emerald-600 hover:underline">Review</button>
                                    <button wire:click="openReject({{ $req->id }})" class="text-red-700 hover:underline">Reject</button>
                                @elseif ($tab === 'disbursement')
                                    <button wire:click="disburse({{ $req->id }})" wire:confirm="Confirm shares have been disbursed?" class="text-green-700 hover:underline">Mark Disbursed</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No requests in this view.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $requests->links() }}
    </div>

    @if ($activeRequest && $mode === 'review')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Review Share Withdrawal</h3>
                <p class="text-sm text-gray-500 mb-4">
                    {{ $activeRequest->member->full_name }} — Available {{ $activeRequest->account->availableShares($activeRequest->id) }} of {{ $activeRequest->account->total_shares }} shares
                    (max withdrawable: {{ $activeRequest->account->maxWithdrawableShares($activeRequest->id) }})
                </p>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="shares_approved" value="Approved Shares" />
                        <x-text-input id="shares_approved" wire:model="shares_approved" type="number" min="1" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('shares_approved')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="treasurer_note" value="Note" />
                        <textarea id="treasurer_note" wire:model="treasurer_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('treasurer_note')" class="mt-1" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="approve" wire:loading.attr="disabled">Endorse to Chairman</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeId && $mode === 'reject')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Reject Share Withdrawal</h3>
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
</div>
