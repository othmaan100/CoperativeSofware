<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan Repayment Batch — {{ $batch->period }}</h2>
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
            <div><p class="text-sm text-gray-500">Matched Amount</p><p class="font-semibold">₦{{ number_format((float) $batch->total_amount, 2) }}</p></div>
            <div><p class="text-sm text-gray-500">Flagged Rows</p><p class="font-semibold">{{ count($batch->flaggedRows()) }}</p></div>

            @if ($batch->status === 'validated')
                <x-primary-button wire:click="post" wire:confirm="Post this batch? Once posted it cannot be reversed except via a reversal request." class="ml-auto">
                    Post Batch
                </x-primary-button>
            @endif
        </div>

        @if ($batch->status !== 'posted' && count($batch->flaggedRows()) > 0)
            <form wire:submit="reupload" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-3">
                <h3 class="font-semibold">Re-upload Corrected File</h3>
                <input wire:model="replacementFile" type="file" accept=".csv,text/csv" class="block w-full text-sm" />
                <x-input-error :messages="$errors->get('replacementFile')" class="mt-1" />
                <x-secondary-button wire:loading.attr="disabled">Replace &amp; Re-validate</x-secondary-button>
            </form>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Staff ID</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Loan No.</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($batch->rows ?? [] as $row)
                        <tr>
                            <td class="px-4 py-3">{{ $row['staff_id'] }}</td>
                            <td class="px-4 py-3">{{ $row['member_name'] ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $row['loan_no'] }}</td>
                            <td class="px-4 py-3 text-right">{{ $row['amount'] !== null ? '₦'.number_format($row['amount'], 2) : '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($row['matched'])
                                    <span class="text-green-700">Matched</span>
                                @else
                                    <span class="text-red-700">{{ $row['error'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No rows.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
