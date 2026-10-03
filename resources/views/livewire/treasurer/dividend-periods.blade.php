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
                                @if ($period->status === 'declared' || $period->status === 'calculated')
                                    <button wire:click="calculate({{ $period->id }})" wire:confirm="{{ $period->status === 'calculated' ? 'Recalculate this period? Existing (unposted) allocations will be replaced.' : 'Calculate dividend/interest allocations for every active member?' }}" class="text-emerald-600 hover:underline">
                                        {{ $period->status === 'calculated' ? 'Recalculate' : 'Calculate' }}
                                    </button>
                                @endif
                                @if ($period->status === 'calculated')
                                    <button wire:click="post({{ $period->id }})" wire:confirm="Post this period? Amounts will be credited to members' Regular Savings accounts and cannot be undone." class="text-green-700 hover:underline font-semibold">
                                        Post
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No dividend periods yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $periods->links() }}
    </div>

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
