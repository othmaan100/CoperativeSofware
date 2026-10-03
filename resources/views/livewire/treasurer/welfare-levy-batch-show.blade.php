<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Welfare Levy Batch — {{ $batch->period }}</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap gap-6 items-center">
            <div><p class="text-sm text-gray-500">Status</p><p class="font-semibold">{{ ucfirst($batch->status) }}</p></div>
            <div><p class="text-sm text-gray-500">Records</p><p class="font-semibold">{{ $batch->total_records }}</p></div>
            <div><p class="text-sm text-gray-500">Total Amount</p><p class="font-semibold">₦{{ number_format((float) $batch->total_amount, 2) }}</p></div>
            <div><p class="text-sm text-gray-500">Flagged Rows</p><p class="font-semibold">{{ count($batch->flaggedRows()) }}</p></div>

            @if ($batch->status === 'validated')
                <x-primary-button wire:click="post" wire:confirm="Post this batch? This credits the welfare fund and cannot be undone." class="ml-auto">
                    Post Batch
                </x-primary-button>
            @endif
        </div>

        @if ($batch->status !== 'posted' && count($batch->flaggedRows()) > 0)
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md px-4 py-3 text-sm">
                Flagged rows will not be posted. Upload a new corrected batch for those members instead.
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Staff ID</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($batch->rows ?? [] as $row)
                        <tr>
                            <td class="px-4 py-3">{{ $row['staff_id'] }}</td>
                            <td class="px-4 py-3">{{ $row['member_name'] ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($row['matched'])
                                    <span class="text-green-700">Matched</span>
                                @else
                                    <span class="text-red-700">{{ $row['error'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-6 text-center text-gray-500">No rows.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
