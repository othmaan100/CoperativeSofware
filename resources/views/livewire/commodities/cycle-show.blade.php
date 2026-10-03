<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $cycle->name }}</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap gap-6 items-center">
            <div><p class="text-sm text-gray-500">Status</p><p class="font-semibold">{{ ucwords(str_replace('_', ' ', $cycle->status)) }}</p></div>
            <div><p class="text-sm text-gray-500">Request Deadline</p><p class="font-semibold">{{ $cycle->request_deadline->format('d M Y') }}</p></div>
            <div><p class="text-sm text-gray-500">Requests</p><p class="font-semibold">{{ $requests->count() }}</p></div>
            @if ($cycle->tenure_months)
                <div><p class="text-sm text-gray-500">Tenure / Moratorium</p><p class="font-semibold">{{ $cycle->tenure_months }} mo. / {{ $cycle->moratorium_months }} mo.</p></div>
            @endif
            <div><p class="text-sm text-gray-500">Markup</p><p class="font-semibold">{{ $cycle->markupPctTotal() }}% ({{ $cycle->markup_admin_pct }}% admin + {{ $cycle->markup_profit_pct }}% profit)</p></div>

            @can('manage_commodity_cycles')
                @if ($cycle->status === 'open')
                    <x-danger-button wire:click="closeRequestsNow" wire:confirm="Close the request window now? Members will no longer be able to submit or edit requests." class="ml-auto">
                        Close Requests Now
                    </x-danger-button>
                @endif
            @endcan
        </div>

        @can('set_loan_interest_rates')
            @if (in_array($cycle->status, ['open', 'requests_closed']))
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="font-semibold mb-3">Markup Rate</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                        <div>
                            <x-input-label for="markup_admin_pct" value="Admin Charge (%)" />
                            <x-text-input id="markup_admin_pct" wire:model="markup_admin_pct" type="number" step="0.01" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="markup_profit_pct" value="Profit (%)" />
                            <x-text-input id="markup_profit_pct" wire:model="markup_profit_pct" type="number" step="0.01" class="mt-1 block w-full" />
                        </div>
                        <x-secondary-button wire:click="saveMarkup">Save Markup</x-secondary-button>
                    </div>
                </div>
            @endif
        @endcan

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Aggregated Demand {{ $cycle->status === 'requests_closed' ? '— Enter Unit Prices' : '(Market Sourcing Sheet)' }}</h3>

            @if ($cycle->status === 'requests_closed')
                @can('price_commodity_cycle')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="tenure_months" value="Tenure (months)" />
                            <x-text-input id="tenure_months" wire:model="tenure_months" type="number" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('tenure_months')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="moratorium_months" value="Moratorium (months)" />
                            <x-text-input id="moratorium_months" wire:model="moratorium_months" type="number" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('moratorium_months')" class="mt-1" />
                        </div>
                    </div>
                @endcan
            @endif

            <table class="w-full text-sm">
                <thead class="text-xs uppercase text-gray-500">
                    <tr>
                        <th class="text-left py-1">Item</th>
                        <th class="text-right py-1">Total Qty</th>
                        <th class="text-left py-1">Unit</th>
                        <th class="text-right py-1">Requests</th>
                        @if ($cycle->status === 'requests_closed')
                            <th class="text-right py-1">Unit Price (₦)</th>
                            <th class="text-right py-1"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($demand as $row)
                        @php $key = $row->commodity_item_id ? "item-{$row->commodity_item_id}" : 'custom-'.strtolower($row->custom_item_text); @endphp
                        <tr class="border-b last:border-0" wire:key="demand-{{ $key }}">
                            <td class="py-1">{{ $row->label }}</td>
                            <td class="py-1 text-right">{{ rtrim(rtrim(number_format($row->total_quantity, 2), '0'), '.') }}</td>
                            <td class="py-1">{{ $row->unit_basis }}</td>
                            <td class="py-1 text-right">{{ $row->request_count }}</td>
                            @if ($cycle->status === 'requests_closed')
                                @can('price_commodity_cycle')
                                    <td class="py-1 text-right">
                                        <input type="number" step="0.01" wire:model="prices.{{ $key }}" class="w-28 text-right text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm" />
                                        <x-input-error :messages="$errors->get('prices.'.$key)" class="mt-1" />
                                    </td>
                                    <td class="py-1 text-right">
                                        <button wire:click="removeDemandItem({{ $row->commodity_item_id ?? 'null' }}, {{ $row->commodity_item_id ? 'null' : "'".addslashes($row->custom_item_text)."'" }})" wire:confirm="Remove this item from the cycle for every member who requested it?" class="text-red-600 hover:underline text-xs">Unavailable</button>
                                    </td>
                                @endcan
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-2 text-gray-500">No items requested in this cycle.</td></tr>
                    @endforelse
                </tbody>
            </table>

            @if ($cycle->status === 'requests_closed')
                @can('price_commodity_cycle')
                    <div class="flex justify-end mt-4">
                        <x-primary-button wire:click="finalizePricing" wire:confirm="Finalize pricing? This locks prices and computes every member's total repayable." wire:loading.attr="disabled">
                            Finalize Pricing
                        </x-primary-button>
                    </div>
                @endcan
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap gap-4 items-center">
            @can('verify_commodity_cycle')
                @if ($cycle->status === 'priced')
                    <x-primary-button wire:click="verify" wire:confirm="Verify this cycle's pricing and totals?">Auditor: Verify Cycle</x-primary-button>
                @endif
            @endcan
            @can('approve_commodity_cycle')
                @if ($cycle->status === 'auditor_verified')
                    <x-primary-button wire:click="approve" wire:confirm="Approve this cycle for chairman authorization?">Store Officer: Approve Cycle</x-primary-button>
                @endif
            @endcan
            @can('authorize_commodity_cycle')
                @if ($cycle->status === 'store_approved')
                    <x-primary-button wire:click="authorize_" wire:confirm="Authorize this cycle? Goods can then be released to members.">Chairman: Authorize Cycle</x-primary-button>
                @endif
            @endcan
            @if (in_array($cycle->status, ['priced', 'auditor_verified', 'store_approved', 'chairman_authorized', 'active']))
                <span class="text-sm text-gray-500">
                    @if ($cycle->auditor_verified_at) Verified {{ $cycle->auditor_verified_at->format('d M Y') }}. @endif
                    @if ($cycle->store_approved_at) Approved {{ $cycle->store_approved_at->format('d M Y') }}. @endif
                    @if ($cycle->chairman_authorized_at) Authorized {{ $cycle->chairman_authorized_at->format('d M Y') }}. @endif
                </span>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                        <th class="px-4 py-3 text-right">Total Repayable</th>
                        <th class="px-4 py-3 text-right">Installment</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($requests as $request)
                        <tr wire:key="req-{{ $request->id }}">
                            <td class="px-4 py-3">{{ $request->member->full_name }}</td>
                            <td class="px-4 py-3 text-right">{{ $request->commodity_subtotal !== null ? '₦'.number_format((float) $request->commodity_subtotal, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $request->total_repayable !== null ? '₦'.number_format((float) $request->total_repayable, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $request->monthly_installment !== null ? '₦'.number_format((float) $request->monthly_installment, 2) : '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($request->status === 'active')
                                    <span class="text-green-700">Released — {{ $request->loan?->loan_no }}</span>
                                @else
                                    {{ ucfirst($request->status) }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @can('release_commodity_goods')
                                    @if ($request->status === 'priced' && in_array($cycle->status, ['chairman_authorized', 'active']))
                                        <button wire:click="releaseGoods({{ $request->id }})" wire:confirm="Release goods to {{ $request->member->full_name }}? This activates their loan and starts the repayment schedule." class="text-emerald-600 hover:underline">Release Goods</button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No requests submitted.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
