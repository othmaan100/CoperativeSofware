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

        {{-- Plain-language guide to declaring rates. Open by default; the Chairman can fold it away. --}}
        <details open class="bg-blue-50 dark:bg-gray-800 border border-blue-200 dark:border-gray-700 rounded-lg p-6 text-sm text-blue-900 dark:text-gray-300">
            <summary class="font-semibold cursor-pointer">What does “Declare Rates” mean?</summary>

            <div class="mt-3 space-y-3">
                <p>
                    It means <strong>deciding how much members get back for the year</strong>, by fixing two percentages.
                    The cooperative earns a profit during the year — mainly from interest on loans and from registration fees —
                    and the rates you declare decide how much of it is shared out.
                </p>

                <div>
                    <p class="font-semibold">You set two percentages:</p>
                    <div class="mt-1 space-y-1">
                        <p><strong>1. Share dividend rate</strong> — a reward for the shares a member owns in the cooperative.
                            <span class="block text-xs">Example: at 10%, a member who held ₦20,000 in shares through the year gets <strong>₦2,000</strong>.</span></p>
                        <p><strong>2. Savings interest rate</strong> — interest on the money a member keeps in savings, like a bank pays.
                            <span class="block text-xs">Example: at 5%, a member who kept ₦100,000 in savings through the year gets <strong>₦5,000</strong>.</span></p>
                    </div>
                </div>

                <p>
                    <strong>“Through the year” means an average.</strong> Money is rewarded for how long it actually stayed in the cooperative.
                    ₦100,000 saved for only half the year counts as about ₦50,000, and money added in the last week earns very little.
                </p>

                <div class="bg-white dark:bg-gray-700/50 border border-blue-200 dark:border-gray-600 rounded-md p-3 space-y-2">
                    <p class="font-semibold">Important: the rates are a percentage of members’ balances — not of the profit.</p>
                    <p>
                        30% dividend does <strong>not</strong> mean “30% of the profit”. It means every member gets 30% of their own share balance.
                        So the total paid out depends on how much members hold, and it can be <strong>more than the profit</strong>.
                    </p>
                    <p class="text-xs">
                        Example: profit is ₦120,000; members hold ₦500,000 in shares and ₦2,000,000 in savings on average.
                        At 30% dividend and 20% interest, members get ₦150,000 + ₦400,000 = <strong>₦550,000</strong> — ₦430,000 more than the profit.
                        To share out only ₦60,000 instead (₦20,000 dividend + ₦40,000 interest), the rates would be 4% and 2%.
                    </p>
                    <p>
                        <strong>The declare form shows a live estimate</strong> of the total payout as you type the rates, next to the profit,
                        and warns you in red if the payout is higher than the profit.
                    </p>
                </div>

                <div>
                    <p class="font-semibold">Declaring does not pay anyone yet. It is step 1 of 3:</p>
                    <div class="mt-1 space-y-1">
                        <p><strong>1. Chairman declares the rates</strong> — the “Declare Rates” button below.</p>
                        <p><strong>2. Treasurer calculates</strong> — the system works out each member’s amount; the Treasurer can check and re-run it.</p>
                        <p><strong>3. Treasurer posts</strong> — the money is added to every member’s account and appears under <em>My Dividends</em>.</p>
                    </div>
                </div>

                <p class="font-medium">
                    Once declared, you cannot edit the rates yourself — agree the percentages with the Board or at the AGM before declaring.
                    If a problem is found before the money is posted, the Treasurer can return the period to you to declare new rates.
                </p>
            </div>
        </details>

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
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
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
                        <x-text-input id="share_dividend_rate_pct" wire:model.live.debounce.400ms="share_dividend_rate_pct" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full" />
                        <p class="text-xs text-gray-500 mt-1">Reward on each member’s average share balance for the year. E.g. 10% on ₦20,000 of shares = ₦2,000.</p>
                        <x-input-error :messages="$errors->get('share_dividend_rate_pct')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="savings_interest_rate_pct" value="Savings Interest Rate (%)" />
                        <x-text-input id="savings_interest_rate_pct" wire:model.live.debounce.400ms="savings_interest_rate_pct" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full" />
                        <p class="text-xs text-gray-500 mt-1">Interest on each member’s average savings balance for the year. E.g. 5% on ₦100,000 of savings = ₦5,000.</p>
                        <x-input-error :messages="$errors->get('savings_interest_rate_pct')" class="mt-1" />
                    </div>
                </div>

                {{-- Live estimate of what these rates would pay out, against the profit. --}}
                <div class="rounded-md border p-3 mt-4 text-sm {{ $preview['over'] ? 'bg-red-50 border-red-300 text-red-800' : 'bg-gray-50 dark:bg-gray-700/50 border-gray-200 dark:border-gray-700' }}">
                    <p class="font-semibold mb-2">Estimated payout at these rates</p>
                    <div class="space-y-1">
                        <div class="flex justify-between gap-4">
                            <span>Dividend: {{ is_numeric($share_dividend_rate_pct) ? $share_dividend_rate_pct : 0 }}% × ₦{{ number_format($avgShareTotal, 2) }} average shares</span>
                            <span class="whitespace-nowrap">₦{{ number_format($preview['share'], 2) }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span>Interest: {{ is_numeric($savings_interest_rate_pct) ? $savings_interest_rate_pct : 0 }}% × ₦{{ number_format($avgSavingsTotal, 2) }} average savings</span>
                            <span class="whitespace-nowrap">₦{{ number_format($preview['savings'], 2) }}</span>
                        </div>
                        <div class="flex justify-between gap-4 font-semibold border-t border-gray-200 dark:border-gray-600 pt-1">
                            <span>Total paid to members</span>
                            <span class="whitespace-nowrap">₦{{ number_format($preview['total'], 2) }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span>Profit available</span>
                            <span class="whitespace-nowrap">₦{{ number_format($preview['profit'], 2) }}</span>
                        </div>
                    </div>
                    @if ($preview['over'])
                        <p class="font-semibold mt-2">
                            ⚠ This pays out ₦{{ number_format($preview['shortfall'], 2) }} more than the profit. The difference would come out of the cooperative’s other funds — mostly members’ own money. Consider lower rates.
                        </p>
                    @elseif ($preview['total'] > 0)
                        <p class="text-xs mt-2">
                            Within the profit — about ₦{{ number_format($preview['profit'] - $preview['total'], 2) }} would stay with the cooperative.
                        </p>
                    @endif
                    <p class="text-xs mt-2 opacity-75">An estimate: the Treasurer’s calculation uses the same balances, so it should come out the same (give or take kobo rounding){{ $activePeriod->fy_end_date->isFuture() ? '. The period has not ended yet, so it assumes balances stay as they are until '.$activePeriod->fy_end_date->format('d M Y') : '' }}.</p>
                </div>

                <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-md px-3 py-2 text-xs mt-4">
                    Once declared, you cannot edit these rates yourself (the Treasurer can return the period to you before posting if needed). Nobody is paid yet — the Treasurer will calculate each member’s amount, then post it to their accounts.
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    @if ($preview['over'])
                        <x-danger-button wire:click="saveDeclare" wire:confirm="These rates pay out ₦{{ number_format($preview['shortfall'], 2) }} MORE than the profit. Declare them anyway?" wire:loading.attr="disabled">Declare Anyway</x-danger-button>
                    @else
                        <x-primary-button wire:click="saveDeclare" wire:loading.attr="disabled">Declare Rates</x-primary-button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
