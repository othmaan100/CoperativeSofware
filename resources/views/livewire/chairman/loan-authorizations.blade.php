<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan Authorizations</h2>
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
                <p class="text-xs text-gray-500 w-full">Filters by the date each loan was disbursed — or, if it has not been disbursed, the date it was authorized or declined.</p>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Loan No.</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3 text-right">Principal</th>
                        <th class="px-4 py-3 text-right">Repayable</th>
                        <th class="px-4 py-3">Tenure</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Dates</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($loans as $loan)
                        <tr wire:key="loan-{{ $loan->id }}">
                            <td class="px-4 py-3 font-medium">{{ $loan->loan_no }}</td>
                            <td class="px-4 py-3">{{ $loan->member->full_name }}</td>
                            <td class="px-4 py-3">{{ $loan->product->name }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $loan->principal_amount, 2) }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $loan->total_repayable, 2) }}</td>
                            <td class="px-4 py-3">{{ $loan->tenure_months }} mo.</td>
                            <td class="px-4 py-3">
                                {{ ucwords(str_replace('_', ' ', $loan->status)) }}
                                @if ($loan->is_legacy_import)
                                    <div class="text-xs text-gray-500">Imported record</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                @include('livewire.partials.loan-dates', ['loan' => $loan])
                            </td>
                            <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                @if ($tab === 'pending')
                                    <button wire:click="openAuthorize({{ $loan->id }})" class="text-emerald-600 hover:underline">Authorize</button>
                                    <button wire:click="openDecline({{ $loan->id }})" class="text-red-700 hover:underline">Decline</button>
                                @endif
                                <a href="{{ route('loans.show', $loan) }}" wire:navigate class="text-gray-500 hover:underline">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-4 py-6 text-center text-gray-500">No loans in this view.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $loans->links() }}
    </div>

    @if ($activeLoan && $mode === 'authorize')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Authorize Loan — {{ $activeLoan->loan_no }}</h3>
                <p class="text-sm text-gray-500 mb-4">
                    {{ $activeLoan->member->full_name }} — ₦{{ number_format((float) $activeLoan->total_repayable, 2) }} over {{ $activeLoan->tenure_months }} months
                    @if ($activeLoan->applied_at)
                        <span class="block">Applied on {{ $activeLoan->applied_at->format('d M Y, g:i a') }}@if ($activeLoan->treasurer_reviewed_at) · endorsed {{ $activeLoan->treasurer_reviewed_at->format('d M Y, g:i a') }}@endif</span>
                    @endif
                </p>
                <x-input-label for="chairman_note" value="Note (optional)" />
                <textarea id="chairman_note" wire:model="chairman_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
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
                <h3 class="font-semibold text-lg mb-4">Decline Loan</h3>
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
