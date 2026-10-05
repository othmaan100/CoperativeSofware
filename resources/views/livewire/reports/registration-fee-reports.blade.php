<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Registration Fee Reports</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        @php
            $totalAmount = (float) ($totals->total_amount ?? 0);
            $totalAdmin = (float) ($totals->total_admin ?? 0);
            $totalProfit = (float) ($totals->total_profit ?? 0);
            $adminSharePct = $totalAmount > 0 ? round($totalAdmin / $totalAmount * 100, 1) : 0;
            $profitSharePct = $totalAmount > 0 ? round($totalProfit / $totalAmount * 100, 1) : 0;
        @endphp

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex flex-wrap items-baseline justify-between gap-2">
                <h3 class="font-semibold">Total Collected</h3>
                <span class="text-sm text-gray-500">{{ $totals->count ?? 0 }} registration(s)</span>
            </div>
            <p class="text-3xl font-bold mt-1">₦{{ number_format($totalAmount, 2) }}</p>

            {{-- Proportional split bar — always visible alongside the total, not just in a separate card. --}}
            <div class="mt-4 h-3 w-full rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 flex">
                <div class="h-full bg-slate-500" style="width: {{ $adminSharePct }}%"></div>
                <div class="h-full bg-emerald-600" style="width: {{ $profitSharePct }}%"></div>
            </div>
            <div class="mt-2 flex flex-wrap gap-x-6 gap-y-1 text-sm">
                <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-slate-500"></span> Admin {{ $adminSharePct }}% — ₦{{ number_format($totalAdmin, 2) }}</span>
                <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span> Profit {{ $profitSharePct }}% — ₦{{ number_format($totalProfit, 2) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Admin Charge <span class="text-sm font-normal text-gray-500">({{ $adminSharePct }}% of total)</span></h3>
                <p class="text-2xl font-bold">₦{{ number_format($totalAdmin, 2) }}</p>
                <p class="text-sm text-gray-500 mt-1">Society running costs</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Profit <span class="text-sm font-normal text-gray-500">({{ $profitSharePct }}% of total)</span></h3>
                <p class="text-2xl font-bold text-emerald-700">₦{{ number_format($totalProfit, 2) }}</p>
                <p class="text-sm text-gray-500 mt-1">Feeds dividends</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="font-semibold">Current Fee &amp; Split (applies to new registrations)</h3>
                <p class="text-sm mt-1">Registration fee: <span class="font-semibold">₦{{ number_format($currentFee, 2) }}</span></p>
                <p class="text-sm text-gray-500 mt-1">{{ $currentSplit['admin_pct'] }}% admin charge + {{ $currentSplit['profit_pct'] }}% profit on every new registration fee. Payments already recorded keep the amount and split that applied when they were paid — the figures above reflect each payment's own split, which is why the overall percentages can differ from this current setting.</p>
            </div>
            @can('manage_registration_fee_settings')
                <x-secondary-button wire:click="openSettingsForm" class="shrink-0">Edit Fee &amp; Split</x-secondary-button>
            @endcan
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">By Payment Source</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr>
                        <th class="text-left py-1">Source</th>
                        <th class="text-right py-1">Count</th>
                        <th class="text-right py-1">Total</th>
                        <th class="text-right py-1">Admin</th>
                        <th class="text-right py-1">Profit</th>
                        <th class="text-right py-1">Split</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bySource as $row)
                        @php
                            $rowAmount = (float) $row->total_amount;
                            $rowAdminPct = $rowAmount > 0 ? round((float) $row->total_admin / $rowAmount * 100, 1) : 0;
                        @endphp
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ ucwords(str_replace('_', ' ', $row->source ?? 'unknown')) }}</td>
                            <td class="py-1 text-right">{{ $row->count }}</td>
                            <td class="py-1 text-right">₦{{ number_format($rowAmount, 2) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->total_admin, 2) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->total_profit, 2) }}</td>
                            <td class="py-1 text-right text-gray-500">{{ $rowAdminPct }}:{{ round(100 - $rowAdminPct, 1) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-2 text-gray-500">No registration fees collected yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Monthly Breakdown</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr>
                        <th class="text-left py-1">Month</th>
                        <th class="text-right py-1">Count</th>
                        <th class="text-right py-1">Total</th>
                        <th class="text-right py-1">Admin</th>
                        <th class="text-right py-1">Profit</th>
                        <th class="text-right py-1">Split</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($byMonth as $row)
                        @php
                            $rowAmount = (float) $row->total_amount;
                            $rowAdminPct = $rowAmount > 0 ? round((float) $row->total_admin / $rowAmount * 100, 1) : 0;
                        @endphp
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $row->period }}</td>
                            <td class="py-1 text-right">{{ $row->count }}</td>
                            <td class="py-1 text-right">₦{{ number_format($rowAmount, 2) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->total_admin, 2) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $row->total_profit, 2) }}</td>
                            <td class="py-1 text-right text-gray-500">{{ $rowAdminPct }}:{{ round(100 - $rowAdminPct, 1) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-2 text-gray-500">No registration fees collected yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Recent Payments</h3>
            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr>
                        <th class="text-left py-1">Member</th>
                        <th class="text-left py-1">Reference</th>
                        <th class="text-right py-1">Amount</th>
                        <th class="text-right py-1">Admin</th>
                        <th class="text-right py-1">Profit</th>
                        <th class="text-right py-1">Split</th>
                        <th class="text-left py-1">Source</th>
                        <th class="text-left py-1">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentPayments as $payment)
                        <tr class="border-b last:border-0">
                            <td class="py-1">{{ $payment->member->full_name }}</td>
                            <td class="py-1 font-mono text-xs">{{ $payment->reference }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $payment->amount, 2) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $payment->admin_amount, 2) }}</td>
                            <td class="py-1 text-right">₦{{ number_format((float) $payment->profit_amount, 2) }}</td>
                            <td class="py-1 text-right text-gray-500">
                                @if ($payment->admin_pct !== null)
                                    {{ rtrim(rtrim(number_format((float) $payment->admin_pct, 1), '0'), '.') }}:{{ rtrim(rtrim(number_format((float) $payment->profit_pct, 1), '0'), '.') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-1">
                                {{ ucwords(str_replace('_', ' ', $payment->source ?? 'unknown')) }}
                                @if ($payment->recordedBy)
                                    <span class="text-xs text-gray-500">({{ $payment->recordedBy->name }})</span>
                                @endif
                            </td>
                            <td class="py-1 text-gray-500">{{ $payment->paid_at?->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="py-2 text-gray-500">No registration fees collected yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($showSettingsForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Edit Registration Fee &amp; Split</h3>
                <p class="text-xs text-gray-500 mb-4">These only affect registrations paid from now on. Fees already paid keep their original amount and split.</p>
                <div class="mb-4">
                    <x-input-label for="fee_amount" value="Registration Fee (₦)" />
                    <x-text-input id="fee_amount" wire:model="fee_amount" type="number" step="0.01" min="1" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('fee_amount')" class="mt-1" />
                    <p class="text-xs text-gray-500 mt-1">The amount every new applicant pays, online or recorded by the Treasurer.</p>
                </div>
                <div>
                    <x-input-label for="admin_pct" value="Admin Charge (%) — the rest is profit and feeds dividends" />
                    <x-text-input id="admin_pct" wire:model="admin_pct" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('admin_pct')" class="mt-1" />
                    <p class="text-xs text-gray-500 mt-1">Profit will be set to {{ is_numeric($admin_pct) ? round(100 - (float) $admin_pct, 2) : '—' }}%.</p>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeSettingsForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="saveSettings" wire:loading.attr="disabled">Save</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
