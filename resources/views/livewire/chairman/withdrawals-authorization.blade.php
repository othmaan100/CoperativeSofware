<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Withdrawal Authorization</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex gap-2 text-sm">
            @foreach (['pending' => 'Awaiting Authorization', 'history' => 'History'] as $key => $label)
                <button wire:click="setTab('{{ $key }}')" class="px-3 py-1.5 rounded-full border {{ $tab === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-600 border-gray-300' }}">{{ $label }}</button>
            @endforeach
        </div>

        @if ($tab === 'history')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex items-end gap-4 flex-wrap">
                <div>
                    <x-input-label for="dateFrom" value="From" />
                    <x-text-input id="dateFrom" wire:model.live="dateFrom" type="date" class="mt-1 block" />
                </div>
                <div>
                    <x-input-label for="dateTo" value="To" />
                    <x-text-input id="dateTo" wire:model.live="dateTo" type="date" class="mt-1 block" />
                </div>
                @if ($dateFrom !== '' || $dateTo !== '')
                    <x-secondary-button wire:click="clearDates">Clear dates</x-secondary-button>
                @endif
                <p class="text-xs text-gray-500 w-full">Filters by the date each request was finished — disbursed, or authorized/declined if not yet paid out.</p>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Account</th>
                        <th class="px-4 py-3 text-right">Approved Amount</th>
                        <th class="px-4 py-3">Notes</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Dates</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($requests as $req)
                        <tr wire:key="wda-{{ $req->id }}">
                            <td class="px-4 py-3">
                                {{ $req->member->full_name }}
                                @if ($req->isForNextOfKin())
                                    <div class="text-xs text-gray-500">Paid to NOK: {{ $req->account_name }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($req->isComplete())
                                    <span class="text-red-600 font-medium">Complete{{ $req->isForNextOfKin() ? ' — Next of Kin' : '' }}</span>
                                @else
                                    Partial
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $req->account->product->name }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $req->approved_amount, 2) }}</td>
                            <td class="px-4 py-3 text-gray-500">
                                @if ($req->treasurer_note)
                                    <div><span class="text-xs font-medium">Treasurer:</span> {{ $req->treasurer_note }}</div>
                                @endif
                                @if ($req->chairman_note)
                                    <div><span class="text-xs font-medium">Chairman:</span> {{ $req->chairman_note }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                {{ ucwords(str_replace('_', ' ', $req->status)) }}
                                @if ($req->is_legacy_import)
                                    <div class="text-xs text-gray-500">Imported record</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                @include('livewire.partials.withdrawal-dates', ['req' => $req])
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                @if ($tab === 'pending')
                                    <button wire:click="openAuthorize({{ $req->id }})" class="text-green-700 hover:underline">Authorize</button>
                                    <button wire:click="openDecline({{ $req->id }})" class="text-red-700 hover:underline">Decline</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No requests in this view.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $requests->links() }}
    </div>

    @if ($activeRequest && $mode === 'authorize')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Authorize Withdrawal</h3>
                <p class="text-sm text-gray-500 mb-4">
                    {{ $activeRequest->member->full_name }} — ₦{{ number_format((float) $activeRequest->approved_amount, 2) }}
                    (account available: ₦{{ number_format($activeRequest->account->availableBalance($activeRequest->id), 2) }} of ₦{{ number_format((float) $activeRequest->account->balance, 2) }})
                    @if ($activeRequest->requested_at)
                        <span class="block">Requested on {{ $activeRequest->requested_at->format('d M Y, g:i a') }}@if ($activeRequest->treasurer_reviewed_at) · endorsed {{ $activeRequest->treasurer_reviewed_at->format('d M Y, g:i a') }}@endif</span>
                    @endif
                </p>

                <x-input-label for="chairman_note" value="Note (required if a rule warning applies)" />
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
                <h3 class="font-semibold text-lg mb-4">Decline Withdrawal</h3>
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
