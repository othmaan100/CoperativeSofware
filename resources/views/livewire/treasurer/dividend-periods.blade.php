<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Dividend Periods</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="flex justify-end">
            <x-primary-button wire:click="openCreateForm">Open New Period</x-primary-button>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Period</th>
                        <th class="px-4 py-3">Dates</th>
                        <th class="px-4 py-3 text-right">Share Rate</th>
                        <th class="px-4 py-3 text-right">Savings Rate</th>
                        <th class="px-4 py-3 text-right">Total Dividend</th>
                        <th class="px-4 py-3 text-right">Total Interest</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($periods as $period)
                        @php
                            $payout = $period->totalPayout();
                            $profit = $profits[$period->id] ?? null;
                            $overProfit = $payout !== null && $profit !== null && $payout > $profit;
                        @endphp
                        <tr wire:key="period-{{ $period->id }}">
                            <td class="px-4 py-3 font-medium">{{ $period->label }}</td>
                            <td class="px-4 py-3">{{ $period->fy_start_date->format('d M Y') }} – {{ $period->fy_end_date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->share_dividend_rate_pct !== null ? $period->share_dividend_rate_pct.'%' : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->savings_interest_rate_pct !== null ? $period->savings_interest_rate_pct.'%' : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->total_share_dividend_amount !== null ? '₦'.number_format((float) $period->total_share_dividend_amount, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $period->total_savings_interest_amount !== null ? '₦'.number_format((float) $period->total_savings_interest_amount, 2) : '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ match($period->status) {
                                    'posted' => 'bg-green-100 text-green-800',
                                    'calculated' => 'bg-blue-100 text-blue-800',
                                    'declared' => 'bg-yellow-100 text-yellow-800',
                                    default => 'bg-gray-100 text-gray-800',
                                } }}">
                                    {{ ucfirst($period->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="openLegacyProfits({{ $period->id }})" class="text-gray-600 hover:underline">Legacy Profit</button>
                                @if ($period->status === 'declared' || $period->status === 'calculated')
                                    <button wire:click="calculate({{ $period->id }})" wire:confirm="{{ $period->status === 'calculated' ? 'Recalculate this period? Existing (unposted) allocations will be replaced.' : 'Calculate dividend/interest allocations for every active member?' }}" class="text-emerald-600 hover:underline">
                                        {{ $period->status === 'calculated' ? 'Recalculate' : 'Calculate' }}
                                    </button>
                                @endif
                                @if ($period->status === 'declared' || $period->status === 'calculated')
                                    <button wire:click="openReturnForm({{ $period->id }})" class="text-gray-600 hover:underline">Return to Chairman</button>
                                @endif
                                @if ($period->status === 'calculated')
                                    <button wire:click="post({{ $period->id }})" wire:confirm="{{ $overProfit ? 'WARNING: this pays out ₦'.number_format($payout - $profit, 2).' MORE than the profit of ₦'.number_format($profit, 2).'. ' : '' }}Post this period? Amounts will be credited to members' Regular Savings accounts and cannot be undone." class="{{ $overProfit ? 'text-red-700' : 'text-green-700' }} hover:underline font-semibold">
                                        {{ $overProfit ? 'Post Anyway' : 'Post' }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @if ($payout !== null && $profit !== null)
                            <tr wire:key="period-check-{{ $period->id }}">
                                <td colspan="8" class="px-4 pb-3 pt-0">
                                    @if ($overProfit)
                                        <div class="bg-red-50 border border-red-300 text-red-800 rounded-md px-3 py-2 text-xs">
                                            ⚠ Total payout ₦{{ number_format($payout, 2) }} is <strong>₦{{ number_format($payout - $profit, 2) }} more</strong> than the profit of ₦{{ number_format($profit, 2) }}.
                                            The difference would come out of the cooperative’s other funds.
                                            @if ($period->status !== 'posted')
                                                Confirm with the Chairman before posting, or use <strong>Return to Chairman</strong> so new rates can be declared.
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-xs text-gray-500">
                                            Total payout ₦{{ number_format($payout, 2) }} of ₦{{ number_format($profit, 2) }} profit — ₦{{ number_format($profit - $payout, 2) }} stays with the cooperative.
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No dividend periods yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $periods->links() }}
    </div>

    @if ($legacyPeriod)
        @php $legacyEditable = $legacyPeriod->status === 'open'; @endphp
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-xl w-full p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="font-semibold text-lg mb-1">Legacy Profit — {{ $legacyPeriod->label }}</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Enter profit for {{ $legacyPeriod->fy_start_date->format('d M Y') }} – {{ $legacyPeriod->fy_end_date->format('d M Y') }}
                    that was earned in the old (manual) records and so is not tracked in this system.
                    It is added to the profit the Chairman sees when declaring rates, and to the payout checks.
                    Only enter profit that is <strong>not</strong> already in this system, so nothing is counted twice.
                </p>

                @if (session('legacy_status'))
                    <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-3 py-2 text-sm mb-3">{{ session('legacy_status') }}</div>
                @endif

                <table class="min-w-full text-sm mb-4">
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        <tr>
                            <td class="py-1.5">Tracked in this system <span class="block text-xs text-gray-500">Loan (incl. commodity) + registration fee profit</span></td>
                            <td class="py-1.5 text-right whitespace-nowrap">₦{{ number_format($legacyBreakdown['system'], 2) }}</td>
                            <td></td>
                        </tr>
                        @foreach ($legacyPeriod->legacyProfits as $entry)
                            <tr wire:key="legacy-{{ $entry->id }}">
                                <td class="py-1.5">
                                    Legacy: {{ $entry->categoryLabel() }}
                                    <span class="block text-xs text-gray-500">
                                        {{ $entry->description ? $entry->description.' · ' : '' }}entered {{ $entry->created_at->format('d M Y, g:i a') }}{{ $entry->enteredBy ? ' by '.$entry->enteredBy->name : '' }}
                                    </span>
                                </td>
                                <td class="py-1.5 text-right whitespace-nowrap">₦{{ number_format((float) $entry->amount, 2) }}</td>
                                <td class="py-1.5 text-right">
                                    @if ($legacyEditable)
                                        <button wire:click="removeLegacyProfit({{ $entry->id }})" wire:confirm="Remove this legacy profit entry?" class="text-red-700 hover:underline text-xs">Remove</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-semibold">
                            <td class="py-1.5">Total profit for this period</td>
                            <td class="py-1.5 text-right whitespace-nowrap">₦{{ number_format($legacyBreakdown['total'], 2) }}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                @if ($legacyEditable)
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-4 space-y-3">
                        <h4 class="font-semibold text-sm">Add legacy profit</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="legacy_category" value="Type" />
                                <select id="legacy_category" wire:model="legacy_category" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm text-sm">
                                    <option value="">Select…</option>
                                    @foreach (\App\Models\DividendLegacyProfit::CATEGORIES as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('legacy_category')" class="mt-1" />
                            </div>
                            <div>
                                <x-input-label for="legacy_amount" value="Profit amount (₦)" />
                                <x-text-input id="legacy_amount" wire:model="legacy_amount" type="number" step="0.01" min="0" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('legacy_amount')" class="mt-1" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="legacy_description" value="Description (optional)" />
                            <x-text-input id="legacy_description" wire:model="legacy_description" type="text" class="mt-1 block w-full" placeholder="e.g. Loan interest Jan–Jun from manual ledger" />
                            <x-input-error :messages="$errors->get('legacy_description')" class="mt-1" />
                        </div>
                        <p class="text-xs text-gray-500">Enter the <strong>profit</strong> only — e.g. the profit share of loan interest or registration fees, not the full amount collected.</p>
                        <div class="flex justify-end">
                            <x-primary-button wire:click="addLegacyProfit" wire:loading.attr="disabled">Add</x-primary-button>
                        </div>
                    </div>
                @else
                    <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-md px-3 py-2 text-xs">
                        Rates have already been {{ $legacyPeriod->status === 'posted' ? 'declared and posted' : 'declared' }} for this period, so its profit is fixed.
                        @if ($legacyPeriod->status !== 'posted')
                            To change it, use <strong>Return to Chairman</strong> first, then add or remove legacy profit.
                        @endif
                    </div>
                @endif

                <div class="flex justify-end mt-6">
                    <x-secondary-button wire:click="closeLegacyProfits">Close</x-secondary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($returningPeriodId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-2">Return to Chairman for New Rates</h3>
                <p class="text-sm text-gray-500 mb-4">
                    This clears the declared rates and any calculation, and reopens the period so the Chairman can declare new rates.
                    Nobody has been paid yet, so no member balances change. The withdrawn rates and your reason are kept in the Activity Log.
                </p>
                <x-input-label for="return_reason" value="Reason" />
                <textarea id="return_reason" wire:model="return_reason" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm" placeholder="e.g. Payout exceeds the year's profit — please declare lower rates."></textarea>
                <x-input-error :messages="$errors->get('return_reason')" class="mt-1" />
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeReturnForm">Cancel</x-secondary-button>
                    <x-danger-button wire:click="returnToChairman" wire:loading.attr="disabled">Return to Chairman</x-danger-button>
                </div>
            </div>
        </div>
    @endif

    @if ($showCreateForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Open New Dividend Period</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="label" value="Label" />
                        <x-text-input id="label" wire:model="label" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('label')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="fy_start_date" value="Start Date" />
                        <x-text-input id="fy_start_date" wire:model="fy_start_date" type="date" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('fy_start_date')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="fy_end_date" value="End Date" />
                        <x-text-input id="fy_end_date" wire:model="fy_end_date" type="date" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('fy_end_date')" class="mt-1" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeCreateForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="createPeriod" wire:loading.attr="disabled">Open Period</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
