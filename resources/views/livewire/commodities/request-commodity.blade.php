<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Commodity Loan Request</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        @if ($editable || $offerFreshApply)
            <form wire:submit="submit" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold">{{ $this->openCycle->name }}</h3>
                    <p class="text-xs text-gray-500">Requests close {{ $this->openCycle->request_deadline->format('d M Y') }}</p>
                </div>
                <p class="text-xs text-gray-500">Prices are fixed by the Secretary after the committee sources current market rates — you won't see prices until then. You can edit or withdraw this request any time before requests close.</p>

                <x-input-error :messages="$errors->get('lines')" class="mt-1" />

                <div class="space-y-3">
                    @foreach ($lines as $i => $line)
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-start border-b border-gray-100 dark:border-gray-700 pb-3" wire:key="line-{{ $line['key'] ?? $i }}">
                            <div class="sm:col-span-5">
                                <div class="relative"
                                     x-data="{
                                        open: false,
                                        search: '',
                                        items: @js($this->catalogue->map(fn ($catalogueItem) => ['id' => (string) $catalogueItem->id, 'label' => $catalogueItem->label()])->values()),
                                        selectedLabel: @js($line['commodity_item_id'] !== '' ? (optional($this->catalogue->firstWhere('id', (int) $line['commodity_item_id']))->label() ?? '') : ''),
                                        get filtered() {
                                            if (this.search.trim() === '') return this.items;
                                            const q = this.search.toLowerCase();
                                            return this.items.filter(option => option.label.toLowerCase().includes(q));
                                        },
                                        choose(option) {
                                            this.selectedLabel = option ? option.label : '';
                                            this.search = '';
                                            this.open = false;
                                            $wire.set('lines.{{ $i }}.commodity_item_id', option ? option.id : '', true);
                                        }
                                     }"
                                     x-on:click.outside="open = false"
                                     x-on:keydown.escape="open = false">
                                    <button type="button"
                                            x-on:click="open = !open; search = ''; if (open) $nextTick(() => $refs.itemSearch{{ $i }}.focus())"
                                            class="flex items-center justify-between w-full text-sm text-left border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm px-3 py-2">
                                        <span x-text="selectedLabel || 'Other (not listed)'" :class="{ 'text-gray-400': !selectedLabel }"></span>
                                        <svg class="w-4 h-4 text-gray-400 shrink-0 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                    </button>
                                    <div x-show="open" class="absolute z-20 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg" style="display: none;">
                                        <input type="text" x-model="search" x-ref="itemSearch{{ $i }}" placeholder="Type to search items..."
                                               class="block w-full text-sm border-0 border-b border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 rounded-t-md focus:ring-0" />
                                        <div class="max-h-60 overflow-y-auto">
                                            <div class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-gray-700" x-on:click="choose(null)">Other (not listed)</div>
                                            <template x-for="option in filtered" :key="option.id">
                                                <div class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-gray-700" x-text="option.label" x-on:click="choose(option)"></div>
                                            </template>
                                            <div x-show="filtered.length === 0" class="px-3 py-2 text-sm text-gray-500">No items match your search.</div>
                                        </div>
                                    </div>
                                </div>
                                @if ($line['commodity_item_id'] === '')
                                    <input type="text" wire:model="lines.{{ $i }}.custom_item_text" placeholder="Describe the item" class="mt-1 block w-full text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm" />
                                @endif
                            </div>
                            <div class="sm:col-span-2">
                                <input type="number" step="0.01" wire:model="lines.{{ $i }}.quantity" placeholder="Qty" class="block w-full text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm" />
                                <x-input-error :messages="$errors->get('lines.'.$i.'.quantity')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-4">
                                @php $selectedItem = $line['commodity_item_id'] !== '' ? $this->catalogue->firstWhere('id', (int) $line['commodity_item_id']) : null; @endphp
                                @if ($selectedItem?->hasUnitOptions())
                                    <select wire:model="lines.{{ $i }}.unit_basis" class="block w-full text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                                        <option value="">Select unit...</option>
                                        @foreach ($selectedItem->unit_options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" wire:model="lines.{{ $i }}.unit_basis" placeholder="e.g. carton, half bag, 2 litres" class="block w-full text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm" />
                                @endif
                                <x-input-error :messages="$errors->get('lines.'.$i.'.unit_basis')" class="mt-1" />
                            </div>
                            <div class="sm:col-span-1 text-right">
                                <button type="button" wire:click="removeLine({{ $i }})" class="text-red-600 text-sm hover:underline">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-secondary-button type="button" wire:click="addLine">Add Another Item</x-secondary-button>

                <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                    <label class="flex items-start gap-2 text-sm">
                        <input type="checkbox" wire:model="salary_deduction_authorized" class="mt-0.5 rounded border-gray-300 text-emerald-600" />
                        <span>I authorize FCE (Technical) Potiskum to deduct the total amount granted to me against the above commodities from my monthly salary, and remit same to the FCE (Technical) Staff Cooperative Society Limited.</span>
                    </label>
                    <x-input-error :messages="$errors->get('salary_deduction_authorized')" class="mt-1" />
                </div>

                <div class="flex justify-between">
                    @if ($editable)
                        <x-danger-button type="button" wire:click="cancel" wire:confirm="Withdraw this commodity request entirely?">Withdraw Request</x-danger-button>
                    @else
                        <span></span>
                    @endif
                    <x-primary-button wire:loading.attr="disabled">{{ $editable ? 'Save Changes' : 'Submit Request' }}</x-primary-button>
                </div>
            </form>
        @elseif ($this->openCycle && $member->hasActiveCommodityLoan())
            <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-md px-4 py-3 text-sm">
                A commodity cycle is currently open, but you have an existing commodity loan still being repaid. You must fully clear it before requesting again.
            </div>
        @elseif ($latest)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-1">Your Request — {{ $latest->cycle->name }}</h3>
                <p class="text-sm text-gray-500 mb-4">Status: {{ ucwords(str_replace('_', ' ', $latest->status)) }}
                    @if ($latest->status === 'submitted' && ! $latest->cycle->isRequestWindowOpen())
                        &mdash; the request window has closed; your final prices and totals will appear here once the Secretary finalizes pricing.
                    @endif
                </p>

                @php $released = in_array($latest->status, ['active', 'not_supplied']); @endphp
                <table class="w-full text-sm mb-4">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr>
                            <th class="text-left py-1">Item</th>
                            <th class="text-right py-1">Qty</th>
                            @if ($released)<th class="text-right py-1">Released</th>@endif
                            <th class="text-left py-1 pl-3">Unit</th>
                            <th class="text-right py-1">Price</th>
                            <th class="text-right py-1">{{ $released ? 'Charged' : 'Line Total' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latest->lines as $line)
                            <tr class="border-b last:border-0 {{ $released && (float) $line->quantity_released === 0.0 ? 'text-gray-400' : '' }}">
                                <td class="py-1">{{ $line->label() }}</td>
                                <td class="py-1 text-right">{{ (float) $line->quantity }}</td>
                                @if ($released)
                                    <td class="py-1 text-right {{ $line->wasShortSupplied() ? 'text-amber-700' : '' }}">
                                        {{ (float) $line->quantity_released === 0.0 ? ($line->shortfallLabel() ?? 'Not in stock') : (float) $line->quantity_released }}
                                        @if ($line->wasShortSupplied() && (float) $line->quantity_released > 0 && $line->shortfallLabel())
                                            <span class="block text-xs">{{ $line->shortfallLabel() }}</span>
                                        @endif
                                    </td>
                                @endif
                                <td class="py-1 pl-3">{{ $line->unit_basis }}</td>
                                <td class="py-1 text-right">{{ $line->fixed_unit_price !== null ? '₦'.number_format((float) $line->fixed_unit_price, 2) : 'Not yet priced' }}</td>
                                <td class="py-1 text-right">
                                    @if ($released)
                                        ₦{{ number_format((float) $line->released_line_total, 2) }}
                                    @else
                                        {{ $line->line_total !== null ? '₦'.number_format((float) $line->line_total, 2) : '—' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($latest->status === 'not_supplied')
                    <p class="text-sm text-red-700">None of your requested items were in stock, so nothing was released and you have no loan from this cycle.</p>
                @elseif ($latest->total_repayable !== null)
                    <div class="grid grid-cols-3 gap-4 text-sm border-t pt-4">
                        <div>
                            <p class="text-gray-500">{{ $released ? 'Value Released' : 'Subtotal' }}</p>
                            <p class="font-semibold">₦{{ number_format((float) $latest->commodity_subtotal, 2) }}</p>
                            @if ($released && abs($latest->requestedSubtotal() - (float) $latest->commodity_subtotal) > 0.001)
                                <p class="text-xs text-gray-500">of ₦{{ number_format($latest->requestedSubtotal(), 2) }} requested</p>
                            @endif
                        </div>
                        <div><p class="text-gray-500">Total Repayable</p><p class="font-semibold">₦{{ number_format((float) $latest->total_repayable, 2) }}</p></div>
                        <div><p class="text-gray-500">Monthly Installment</p><p class="font-semibold">₦{{ number_format((float) $latest->monthly_installment, 2) }}</p></div>
                    </div>
                @endif

                @if ($latest->status === 'active')
                    <p class="text-sm text-emerald-700 mt-4">
                        Your goods have been released — track repayment under <a href="{{ route('my-loans') }}" wire:navigate class="underline">My Loans</a> (loan {{ $latest->loan?->loan_no }}).
                        @if ($latest->lines->contains(fn ($line) => $line->wasShortSupplied()))
                            Some items were not in stock; you are only charged for what you received.
                        @endif
                    </p>
                @endif
            </div>
        @else
            <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-md px-4 py-3 text-sm">
                There is no commodity cycle currently open for requests. Check back once the Secretary opens the next one.
            </div>
        @endif
    </div>
</div>
