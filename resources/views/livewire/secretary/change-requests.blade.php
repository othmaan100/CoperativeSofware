<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Member Change Requests</h2>
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
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Field</th>
                        <th class="px-4 py-3">Current</th>
                        <th class="px-4 py-3">Requested</th>
                        <th class="px-4 py-3">Requested At</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($requests as $req)
                        <tr wire:key="cr-{{ $req->id }}">
                            <td class="px-4 py-3">
                                <a href="{{ route('members.show', $req->member) }}" wire:navigate class="text-emerald-600 hover:underline">
                                    {{ $req->member->full_name }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $req->fieldLabel() }}</td>
                            <td class="px-4 py-3 text-gray-500 max-w-[16rem] truncate">{{ $req->old_value }}</td>
                            <td class="px-4 py-3 max-w-[16rem] truncate">{{ $req->new_value }}</td>
                            <td class="px-4 py-3">{{ $req->requested_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="approve({{ $req->id }})" wire:confirm="Approve this change?" class="text-green-700 hover:underline">Approve</button>
                                <button wire:click="openReject({{ $req->id }})" class="text-red-700 hover:underline">Reject</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No pending change requests.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $requests->links() }}
    </div>

    @if ($activeRequestId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Reject Change Request</h3>
                <x-input-label for="review_reason" value="Reason" />
                <textarea id="review_reason" wire:model="review_reason" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('review_reason')" class="mt-1" />

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-danger-button wire:click="reject" wire:loading.attr="disabled">Confirm Rejection</x-danger-button>
                </div>
            </div>
        </div>
    @endif
</div>
