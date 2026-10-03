<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Voluntary Deposits</h2>
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
                        <th class="px-4 py-3">Account</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3">Note</th>
                        <th class="px-4 py-3">Receipt</th>
                        <th class="px-4 py-3">Logged</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($intents as $intent)
                        <tr wire:key="intent-{{ $intent->id }}">
                            <td class="px-4 py-3">{{ $intent->member->full_name }}</td>
                            <td class="px-4 py-3">{{ $intent->account->product->name }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $intent->amount, 2) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $intent->note }}</td>
                            <td class="px-4 py-3">
                                @if ($intent->receipt_path)
                                    <a href="{{ route('voluntary-deposits.receipt', $intent) }}" target="_blank" class="text-emerald-600 hover:underline">View</a>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $intent->requested_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="confirm({{ $intent->id }})" wire:confirm="Confirm receipt and post this deposit?" class="text-green-700 hover:underline">Confirm</button>
                                <button wire:click="openDecline({{ $intent->id }})" class="text-red-700 hover:underline">Decline</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No pending voluntary deposits.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $intents->links() }}
    </div>

    @if ($activeIntentId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Decline Deposit</h3>
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
