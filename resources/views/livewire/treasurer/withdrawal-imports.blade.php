<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Withdrawal Import</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <form wire:submit="processUpload" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="font-semibold">Import Past Withdrawals</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        For withdrawals paid out from the manual books before the system was used. Each withdrawal is taken from the member's Regular Savings
                        <strong>on its withdrawal date</strong>, so balances, statements and dividend calculations show it at the right time.
                    </p>
                </div>
                <x-secondary-button type="button" wire:click="downloadTemplate" class="shrink-0">Download Template</x-secondary-button>
            </div>

            <div class="text-xs text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 rounded-md p-3 space-y-1">
                <p><strong>Required columns:</strong> <code>staff_id</code>, <code>amount</code>, <code>withdrawal_date</code> (DD/MM/YYYY or YYYY-MM-DD).</p>
                <p><strong>Optional:</strong> <code>type</code> (partial or complete; blank = partial), <code>reference</code>, <code>bank_name</code>, <code>account_number</code>, <code>account_name</code>, <code>reason</code>.</p>
                <p>Post the contribution batches up to each withdrawal's date first. A withdrawal is flagged if the member's savings on that date could not have covered it.</p>
            </div>

            <div>
                <x-input-label for="file" value="Withdrawal File (CSV)" />
                <input id="file" wire:model="file" type="file" accept=".csv,text/csv" class="mt-1 block w-full text-sm" />
                <x-input-error :messages="$errors->get('file')" class="mt-1" />
            </div>

            <div class="flex justify-end">
                <x-primary-button wire:loading.attr="disabled">Upload &amp; Check</x-primary-button>
            </div>
        </form>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Uploaded</th>
                        <th class="px-4 py-3">Uploaded By</th>
                        <th class="px-4 py-3">Records</th>
                        <th class="px-4 py-3 text-right">Total (valid rows)</th>
                        <th class="px-4 py-3 pl-6">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($batches as $batch)
                        <tr wire:key="wimport-{{ $batch->id }}">
                            <td class="px-4 py-3 font-medium">#{{ $batch->id }} · {{ $batch->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">{{ $batch->uploadedBy->name }}</td>
                            <td class="px-4 py-3">{{ $batch->total_records }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $batch->total_amount, 2) }}</td>
                            <td class="px-4 py-3 pl-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $batch->status === 'posted' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($batch->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('treasurer.withdrawal-imports.show', $batch) }}" wire:navigate class="text-emerald-600 hover:underline">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No withdrawal imports yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $batches->links() }}
    </div>
</div>
