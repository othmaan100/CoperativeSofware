<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Contribution Batches</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <form wire:submit="processUpload" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="font-semibold">Upload Monthly Contribution File</h3>
                    <p class="text-xs text-gray-500">CSV with headers <code>staff_id,amount,shares</code>. The <code>shares</code> column is optional — leave blank or 0 for members not buying shares this period. Unmatched Staff IDs are flagged, not blocking the whole batch. The downloadable template also includes each member's IPPIS Number for your reference — it isn't required in the upload and doesn't affect matching.</p>
                </div>
                <x-secondary-button type="button" wire:click="downloadTemplate" class="shrink-0">
                    Download Template (Active Contributors)
                </x-secondary-button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="period" value="Period (YYYY-MM)" />
                    <x-text-input id="period" wire:model="period" type="text" placeholder="2026-09" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('period')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="file" value="Contribution File (CSV)" />
                    <input id="file" wire:model="file" type="file" accept=".csv,text/csv" class="mt-1 block w-full text-sm" />
                    <x-input-error :messages="$errors->get('file')" class="mt-1" />
                </div>
            </div>

            <div class="flex justify-end">
                <x-primary-button wire:loading.attr="disabled">Upload &amp; Validate</x-primary-button>
            </div>
        </form>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Period</th>
                        <th class="px-4 py-3">Uploaded By</th>
                        <th class="px-4 py-3">Records</th>
                        <th class="px-4 py-3">Total Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($batches as $batch)
                        <tr wire:key="batch-{{ $batch->id }}">
                            <td class="px-4 py-3 font-medium">{{ $batch->period }}</td>
                            <td class="px-4 py-3">{{ $batch->uploadedBy->name }}</td>
                            <td class="px-4 py-3">{{ $batch->total_records }}</td>
                            <td class="px-4 py-3">₦{{ number_format((float) $batch->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $batch->status === 'posted' ? 'bg-green-100 text-green-800' : ($batch->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($batch->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('treasurer.contribution-batches.show', $batch) }}" wire:navigate class="text-emerald-600 hover:underline">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No batches uploaded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $batches->links() }}
    </div>
</div>
