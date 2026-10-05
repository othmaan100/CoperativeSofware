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
                        <th class="text-left py-1 pl-4">Unit</th>
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
                            <td class="py-1 pl-4">{{ $row->unit_basis }}</td>
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

        @if ($cycle->status === 'priced')
            @can('verify_commodity_cycle')
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="font-semibold">Auditor: Verify Prices</h3>
                    <p class="text-xs text-gray-500 mb-3">
                        Check each unit price the Secretary set. If a price is wrong, correct it here — every member's
                        totals are recalculated, and the Secretary's original price is kept on record.
                    </p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-xs uppercase text-gray-500">
                                <tr>
                                    <th class="py-2 pr-3">Item</th>
                                    <th class="py-2 pr-3 text-right">Qty Requested</th>
                                    <th class="py-2 pr-3 text-right">Secretary's Price</th>
                                    <th class="py-2 pl-6 pr-3">Verified Price (₦)</th>
                                    <th class="py-2 text-right">Value</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($cycleItems as $item)
                                    @php
                                        $entered = $auditPrices[$item->id] ?? '';
                                        $changed = is_numeric($entered) && abs((float) $entered - (float) $item->unit_price) >= 0.001;
                                        $qty = $item->quantityRequested();
                                    @endphp
                                    <tr wire:key="audit-{{ $item->id }}" class="{{ $changed ? 'bg-amber-50 dark:bg-amber-900/20' : '' }}">
                                        <td class="py-2 pr-3">{{ $item->label() }}</td>
                                        <td class="py-2 pr-3 text-right">{{ $qty + 0 }}</td>
                                        <td class="py-2 pr-3 text-right">₦{{ number_format((float) $item->unit_price, 2) }}</td>
                                        <td class="py-2 pl-6 pr-3">
                                            <input type="number" step="0.01" min="0" wire:model.live.debounce.400ms="auditPrices.{{ $item->id }}"
                                                   class="w-32 text-right text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-md shadow-sm">
                                            @if ($changed)<span class="block text-xs text-amber-700">Corrected</span>@endif
                                            <x-input-error :messages="$errors->get('auditPrices.'.$item->id)" class="mt-1" />
                                        </td>
                                        <td class="py-2 text-right">₦{{ number_format($qty * (is_numeric($entered) ? (float) $entered : 0), 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-primary-button wire:click="verify" wire:loading.attr="disabled" wire:confirm="Verify these prices? Any corrected price will update every member's totals.">Verify Prices</x-primary-button>
                    </div>
                </div>
            @endcan
        @endif

        @if ($cycle->status === 'auditor_verified')
            @can('approve_commodity_cycle')
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="font-semibold">Store Officer: Verify Stock in Store</h3>
                    <p class="text-xs text-gray-500 mb-3">
                        Count what is physically in the store. Enter how many are in good condition, and how many are
                        damaged. Only good-condition items can be released, so if there are fewer than requested, members
                        are served in turn until the good stock runs out.
                    </p>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-xs uppercase text-gray-500">
                                <tr>
                                    <th class="py-2 pr-3">Item</th>
                                    <th class="py-2 pr-3 text-right">Qty Requested</th>
                                    <th class="py-2 pr-3">Good Condition</th>
                                    <th class="py-2 pr-3">Damaged</th>
                                    <th class="py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($cycleItems as $item)
                                    @php
                                        $requested = $item->quantityRequested();
                                        $good = $stockGood[$item->id] ?? '';
                                        $short = is_numeric($good) && (float) $good < $requested;
                                    @endphp
                                    <tr wire:key="stock-{{ $item->id }}" class="{{ $short ? 'bg-amber-50 dark:bg-amber-900/20' : '' }}">
                                        <td class="py-2 pr-3">{{ $item->label() }}</td>
                                        <td class="py-2 pr-3 text-right">{{ $requested + 0 }}</td>
                                        <td class="py-2 pr-3">
                                            <input type="number" step="0.01" min="0" wire:model.live.debounce.400ms="stockGood.{{ $item->id }}"
                                                   class="w-24 text-right text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-md shadow-sm">
                                            <x-input-error :messages="$errors->get('stockGood.'.$item->id)" class="mt-1" />
                                        </td>
                                        <td class="py-2 pr-3">
                                            <input type="number" step="0.01" min="0" wire:model="stockDamaged.{{ $item->id }}"
                                                   class="w-24 text-right text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-md shadow-sm">
                                            <x-input-error :messages="$errors->get('stockDamaged.'.$item->id)" class="mt-1" />
                                        </td>
                                        <td class="py-2 text-xs text-amber-700">{{ $short ? 'Short by '.($requested - (float) $good) : '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-primary-button wire:click="approve" wire:loading.attr="disabled" wire:confirm="Confirm these store quantities? Release will be limited to the good-condition stock.">Verify Stock</x-primary-button>
                    </div>
                </div>
            @endcan
        @endif

        @if (in_array($cycle->status, ['priced', 'auditor_verified', 'store_approved', 'chairman_authorized', 'active']) && $cycleItems->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">Item Prices &amp; Stock</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-xs uppercase text-gray-500">
                            <tr>
                                <th class="py-2 pr-3">Item</th>
                                <th class="py-2 pr-3 text-right">Unit Price</th>
                                <th class="py-2 pr-3 text-right">Requested</th>
                                <th class="py-2 pr-3 text-right">Good in Store</th>
                                <th class="py-2 pr-3 text-right">Damaged</th>
                                <th class="py-2 pr-3 text-right">Released</th>
                                <th class="py-2 text-right">Good Left</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($cycleItems as $item)
                                <tr wire:key="summary-{{ $item->id }}">
                                    <td class="py-2 pr-3">{{ $item->label() }}</td>
                                    <td class="py-2 pr-3 text-right">
                                        ₦{{ number_format((float) $item->unit_price, 2) }}
                                        @if ($item->wasRevisedByAuditor())
                                            <span class="block text-xs text-amber-700">Auditor corrected from ₦{{ number_format((float) $item->original_unit_price, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-2 pr-3 text-right">{{ $item->quantityRequested() + 0 }}</td>
                                    <td class="py-2 pr-3 text-right">{{ $item->quantity_in_store !== null ? (float) $item->quantity_in_store : '—' }}</td>
                                    <td class="py-2 pr-3 text-right">{{ $item->quantity_damaged !== null ? (float) $item->quantity_damaged : '—' }}</td>
                                    <td class="py-2 pr-3 text-right">{{ $item->quantityReleased() + 0 }}</td>
                                    <td class="py-2 text-right">{{ $item->quantityAvailable() !== null ? $item->quantityAvailable() + 0 : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @php $canAuthorize = $cycle->status === 'store_approved' && auth()->user()->can('authorize_commodity_cycle'); @endphp
        @if ($canAuthorize || $cycle->auditor_verified_at || $cycle->store_approved_at || $cycle->chairman_authorized_at)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap gap-4 items-center">
                @if ($canAuthorize)
                    <x-primary-button wire:click="authorize_" wire:confirm="Authorize this cycle? Goods can then be released to members.">Chairman: Authorize Cycle</x-primary-button>
                @endif
                <span class="text-sm text-gray-500">
                    @if ($cycle->auditor_verified_at) Prices verified {{ $cycle->auditor_verified_at->format('d M Y') }}. @endif
                    @if ($cycle->store_approved_at) Stock verified {{ $cycle->store_approved_at->format('d M Y') }}. @endif
                    @if ($cycle->chairman_authorized_at) Authorized {{ $cycle->chairman_authorized_at->format('d M Y') }}. @endif
                </span>
            </div>
        @endif

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
                            <td class="px-4 py-3 text-right">
                                {{ $request->commodity_subtotal !== null ? '₦'.number_format((float) $request->commodity_subtotal, 2) : '—' }}
                                @if (in_array($request->status, ['active', 'not_supplied']) && abs($request->requestedSubtotal() - (float) $request->commodity_subtotal) > 0.001)
                                    <span class="block text-xs text-gray-500">of ₦{{ number_format($request->requestedSubtotal(), 2) }} requested</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">{{ $request->total_repayable !== null ? '₦'.number_format((float) $request->total_repayable, 2) : '—' }}</td>
                            <td class="px-4 py-3 text-right">{{ $request->monthly_installment !== null ? '₦'.number_format((float) $request->monthly_installment, 2) : '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($request->status === 'active')
                                    <span class="text-green-700">Released — {{ $request->loan?->loan_no }}</span>
                                    @if ($request->lines->contains(fn ($line) => $line->wasShortSupplied()))
                                        <span class="block text-xs text-amber-700">Part-supplied</span>
                                    @endif
                                @elseif ($request->status === 'not_supplied')
                                    <span class="text-red-700">Not supplied — nothing in stock</span>
                                @else
                                    {{ ucfirst($request->status) }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @can('release_commodity_goods')
                                    @if ($request->status === 'priced' && in_array($cycle->status, ['chairman_authorized', 'active']))
                                        <button wire:click="openRelease({{ $request->id }})" class="text-emerald-600 hover:underline">Release Goods</button>
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

    @if ($releaseRequest)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="font-semibold text-lg">Release Goods — {{ $releaseRequest->member->full_name }}</h3>
                <p class="text-xs text-gray-500 mb-4">
                    Hand over only items that are available, undamaged and in good condition. Enter the quantity you are
                    releasing; if it is less than requested, say why. Only items released are charged to the member's loan.
                </p>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-xs uppercase text-gray-500">
                            <tr>
                                <th class="py-2 pr-3">Item</th>
                                <th class="py-2 pr-3 text-right">Requested</th>
                                <th class="py-2 px-3 text-right whitespace-nowrap">Good Stock Left</th>
                                <th class="py-2 px-3 text-right whitespace-nowrap">Unit Price</th>
                                <th class="py-2 px-3">Qty Released</th>
                                <th class="py-2 pl-3 text-right">Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($releaseRequest->lines as $line)
                                @php
                                    $qty = $releaseQuantities[$line->id] ?? '';
                                    $value = is_numeric($qty) ? (float) $qty * (float) $line->fixed_unit_price : 0;
                                    $none = is_numeric($qty) && (float) $qty === 0.0;
                                    $short = is_numeric($qty) && (float) $qty < (float) $line->quantity;
                                    $left = $releaseAvailable[$line->id] ?? null;
                                @endphp
                                <tr wire:key="release-line-{{ $line->id }}" class="{{ $none ? 'bg-red-50 dark:bg-red-900/20' : ($short ? 'bg-amber-50 dark:bg-amber-900/20' : '') }}">
                                    <td class="py-2 pr-3">{{ $line->label() }}<span class="block text-xs text-gray-500">{{ $line->unit_basis }}</span></td>
                                    <td class="py-2 pr-3 text-right">{{ (float) $line->quantity }}</td>
                                    <td class="py-2 px-3 text-right {{ $left !== null && $left < (float) $line->quantity ? 'text-amber-700 font-semibold' : '' }}">{{ $left === null ? '—' : $left + 0 }}</td>
                                    <td class="py-2 px-3 text-right whitespace-nowrap">₦{{ number_format((float) $line->fixed_unit_price, 2) }}</td>
                                    <td class="py-2 pr-3">
                                        <div class="flex items-center gap-2">
                                            <input type="number" step="0.01" min="0" max="{{ $left === null ? (float) $line->quantity : min((float) $line->quantity, $left) }}"
                                                   wire:model.live.debounce.300ms="releaseQuantities.{{ $line->id }}"
                                                   class="w-24 text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-md shadow-sm">
                                            <button type="button" wire:click="markNotInStock({{ $line->id }})" class="text-xs text-red-700 hover:underline whitespace-nowrap">Not in stock</button>
                                            <button type="button" wire:click="markDamaged({{ $line->id }})" class="text-xs text-red-700 hover:underline whitespace-nowrap">Damaged</button>
                                        </div>
                                        <x-input-error :messages="$errors->get('releaseQuantities.'.$line->id)" class="mt-1" />
                                        @if ($short)
                                            <select wire:model.live="releaseReasons.{{ $line->id }}" class="mt-1 text-xs border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-md shadow-sm">
                                                <option value="">Reason for shortfall...</option>
                                                @foreach (\App\Models\CommodityRequestLine::SHORTFALL_REASONS as $reasonKey => $reasonLabel)
                                                    <option value="{{ $reasonKey }}">{{ $reasonLabel }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('releaseReasons.'.$line->id)" class="mt-1" />
                                        @endif
                                    </td>
                                    <td class="py-2 pl-3 text-right whitespace-nowrap">{{ $none ? 'Not released' : '₦'.number_format($value, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm border-t pt-4">
                    <div><p class="text-gray-500">Requested</p><p class="font-semibold">₦{{ number_format($releasePreview->requested, 2) }}</p></div>
                    <div><p class="text-gray-500">Released</p><p class="font-semibold">₦{{ number_format($releasePreview->subtotal, 2) }}</p></div>
                    <div><p class="text-gray-500">Loan (incl. {{ $cycle->markupPctTotal() }}% markup)</p><p class="font-semibold text-emerald-700">₦{{ number_format($releasePreview->total, 2) }}</p></div>
                    <div><p class="text-gray-500">Monthly Installment</p><p class="font-semibold">₦{{ number_format($releasePreview->installment, 2) }}</p></div>
                </div>

                @if ($releasePreview->subtotal <= 0)
                    <p class="mt-3 text-sm text-red-700">Nothing is being released. Confirming will close this request as not supplied — no loan will be created.</p>
                @endif

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeRelease">Cancel</x-secondary-button>
                    <x-primary-button wire:click="confirmRelease" wire:loading.attr="disabled"
                        wire:confirm="{{ $releasePreview->subtotal > 0 ? 'Release these goods? This creates a loan of ₦'.number_format($releasePreview->total, 2).' and starts the repayment schedule.' : 'Close this request as not supplied? No loan will be created.' }}">
                        {{ $releasePreview->subtotal > 0 ? 'Confirm Release' : 'Close as Not Supplied' }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
