<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Withdrawal Import #{{ $batch->id }}</h2>
    </x-slot>

    @php
        $matched = $batch->matchedRows();
        $flagged = $batch->flaggedRows();
    @endphp

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ ucfirst($batch->status) }}</dd></div>
                <div><dt class="text-gray-500">Valid Rows</dt><dd class="font-medium text-green-700">{{ count($matched) }}</dd></div>
                <div><dt class="text-gray-500">Flagged Rows</dt><dd class="font-medium {{ count($flagged) ? 'text-red-700' : '' }}">{{ count($flagged) }}</dd></div>
                <div><dt class="text-gray-500">Total to Record</dt><dd class="font-medium">₦{{ number_format((float) $batch->total_amount, 2) }}</dd></div>
            </dl>

            @if ($batch->status !== 'posted')
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700 flex flex-wrap items-end justify-between gap-4">
                    <form wire:submit="reupload" class="flex flex-wrap items-end gap-3">
                        <div>
                            <x-input-label for="replacementFile" value="Replace with a corrected file" />
                            <input id="replacementFile" wire:model="replacementFile" type="file" accept=".csv,text/csv" class="mt-1 block text-sm" />
                            <x-input-error :messages="$errors->get('replacementFile')" class="mt-1" />
                        </div>
                        <x-secondary-button type="submit" wire:loading.attr="disabled">Re-upload</x-secondary-button>
                    </form>

                    <div class="flex gap-2">
                        @if (count($flagged))
                            <x-secondary-button wire:click="recheck" wire:loading.attr="disabled">Re-check Flagged Rows</x-secondary-button>
                        @endif
                        <x-primary-button wire:click="post" wire:confirm="Record {{ count($matched) }} withdrawal(s) against members' savings? This cannot be undone." wire:loading.attr="disabled" :disabled="! count($matched)">
                            Post {{ count($matched) }} Withdrawal(s)
                        </x-primary-button>
                    </div>
                </div>
                @if (count($flagged))
                    <p class="text-xs text-gray-500 mt-3">Flagged rows are skipped when posting. Fix them in the file and re-upload, or, if they were flagged for low savings, post the missing contribution batches and click <em>Re-check Flagged Rows</em>.</p>
                @endif
            @else
                <p class="text-sm text-gray-500 mt-4">Posted {{ $batch->posted_at?->format('d M Y H:i') }}.</p>
            @endif
        </div>

        @if (count($flagged))
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
                <h3 class="font-semibold px-4 pt-4 text-red-700">Flagged Rows</h3>
                <table class="min-w-full text-sm mt-2">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Line</th>
                            <th class="px-4 py-3">Staff ID</th>
                            <th class="px-4 py-3">Member</th>
                            <th class="px-4 py-3 text-right">Amount</th>
                            <th class="px-4 py-3 pl-6">Date</th>
                            <th class="px-4 py-3">Problem</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($flagged as $row)
                            <tr>
                                <td class="px-4 py-3">{{ $row['line'] }}</td>
                                <td class="px-4 py-3">{{ $row['staff_id'] }}</td>
                                <td class="px-4 py-3">{{ $row['member_name'] ?? '—' }}</td>
                                <td class="px-4 py-3 text-right">{{ $row['amount'] !== null ? '₦'.number_format($row['amount'], 2) : '—' }}</td>
                                <td class="px-4 py-3 pl-6 whitespace-nowrap">{{ $row['withdrawal_date'] ? \Illuminate\Support\Carbon::parse($row['withdrawal_date'])->format('d/m/Y') : '—' }}</td>
                                <td class="px-4 py-3 text-red-700">{{ $row['error'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <h3 class="font-semibold px-4 pt-4">{{ $batch->status === 'posted' ? 'Recorded Withdrawals' : 'Valid Rows' }}</h3>
            <table class="min-w-full text-sm mt-2">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Line</th>
                        <th class="px-4 py-3">Staff ID</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3 pl-6">Date</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Reference</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse (collect($matched)->sortBy('withdrawal_date') as $row)
                        <tr>
                            <td class="px-4 py-3">{{ $row['line'] }}</td>
                            <td class="px-4 py-3">{{ $row['staff_id'] }}</td>
                            <td class="px-4 py-3">{{ $row['member_name'] }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format($row['amount'], 2) }}</td>
                            <td class="px-4 py-3 pl-6 whitespace-nowrap">{{ \Illuminate\Support\Carbon::parse($row['withdrawal_date'])->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ ucfirst($row['type']) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $row['reference'] ?: '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No valid rows.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('treasurer.withdrawal-imports.index') }}" wire:navigate class="inline-block text-sm text-emerald-600 hover:underline">← All withdrawal imports</a>
    </div>
</div>
