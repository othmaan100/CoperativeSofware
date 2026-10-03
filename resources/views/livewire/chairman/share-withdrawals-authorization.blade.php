<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Share Withdrawal Authorization</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex gap-2 text-sm">
            @foreach (['pending' => 'Pending Authorization', 'history' => 'History'] as $key => $label)
                <button wire:click="setTab('{{ $key }}')" class="px-3 py-1.5 rounded-full border {{ $tab === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-600 border-gray-300' }}">{{ $label }}</button>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3 text-right">Approved Shares</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($requests as $req)
                        <tr wire:key="wd-{{ $req->id }}">
                            <td class="px-4 py-3">{{ $req->member->full_name }}</td>
                            <td class="px-4 py-3 text-right">{{ $req->shares_approved }} shares</td>
                            <td class="px-4 py-3">{{ ucwords(str_replace('_', ' ', $req->status)) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @if ($tab === 'pending')
                                    <button wire:click="openAuthorize({{ $req->id }})" class="text-emerald-600 hover:underline">Authorize</button>
                                    <button wire:click="openDecline({{ $req->id }})" class="text-red-700 hover:underline">Decline</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No requests in this view.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $requests->links() }}
    </div>

    @if ($activeRequest && $mode === 'authorize')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Authorize Share Withdrawal</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activeRequest->member->full_name }} — {{ $activeRequest->shares_approved }} share(s)</p>
                <x-input-label for="chairman_note" value="Note (optional)" />
                <textarea id="chairman_note" wire:model="chairman_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('chairman_note')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="authorize_" wire:loading.attr="disabled">Authorize</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeId && $mode === 'decline')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Decline Share Withdrawal</h3>
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
