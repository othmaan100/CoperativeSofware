<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Dividend Declarations</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-1">Financial Year Start Month</h3>
            <p class="text-xs text-gray-500 mb-4">Only affects periods opened by the Treasurer from now on — existing periods keep their own dates.</p>
            <div class="flex items-end gap-3">
                <div class="max-w-xs">
                    <x-input-label for="fy_start_month" value="Start Month (1–12)" />
                    <x-text-input id="fy_start_month" wire:model="fy_start_month" type="number" min="1" max="12" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('fy_start_month')" class="mt-1" />
                </div>
                <x-primary-button wire:click="saveFyStartMonth">Save</x-primary-button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Period</th>
                        <th class="px-4 py-3">Dates</th>
                        <th class="px-4 py-3 text-right">Share Rate</th>
                        <th class="px-4 py-3 text-right">Savings Rate</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($periods as $period)
                        <tr wire:key="period-{{ $period->id }}">
                            <td class="px-4 py-3 font-medium">{{ $period->label }}</td>
                            <td class="px-4 py-3">{{ $period->fy_start_date->format('d M Y') }} – {{ $period->fy_end_date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->share_dividend_rate_pct !== null ? $period->share_dividend_rate_pct.'%' : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->savings_interest_rate_pct !== null ? $period->savings_interest_rate_pct.'%' : '—' }}</td>
                            <td class="px-4 py-3">{{ ucfirst($period->status) }}</td>
                            <td class="px-4 py-3 text-right">
                                @if ($period->status === 'open')
                                    <button wire:click="openDeclareForm({{ $period->id }})" class="text-emerald-600 hover:underline">Declare Rates</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No dividend periods yet — ask the Treasurer to open one.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $periods->links() }}
    </div>

    @if ($activePeriod)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Declare Rates — {{ $activePeriod->label }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activePeriod->fy_start_date->format('d M Y') }} – {{ $activePeriod->fy_end_date->format('d M Y') }}</p>

                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-md p-3 mb-4 text-sm">
                    <p class="text-gray-500">Loan (incl. commodity) + registration fee profit booked in this range:</p>
                    <p class="font-semibold text-lg">₦{{ number_format((float) $distributableEstimate, 2) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Advisory only — this is booked profit, not necessarily cash already collected, and doesn't include anything outside this system. The Treasurer will see the actual declared total compared against this figure after calculation.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="share_dividend_rate_pct" value="Share Capital Dividend Rate (%)" />
                        <x-text-input id="share_dividend_rate_pct" wire:model="share_dividend_rate_pct" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('share_dividend_rate_pct')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="savings_interest_rate_pct" value="Savings Interest Rate (%)" />
                        <x-text-input id="savings_interest_rate_pct" wire:model="savings_interest_rate_pct" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('savings_interest_rate_pct')" class="mt-1" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="saveDeclare" wire:loading.attr="disabled">Declare Rates</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
