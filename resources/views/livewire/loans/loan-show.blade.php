<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Loan {{ $loan->loan_no }}</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <dl class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                <div><dt class="text-gray-500">Member</dt><dd class="font-medium">{{ $loan->member->full_name }}</dd></div>
                <div><dt class="text-gray-500">Product</dt><dd class="font-medium">{{ $loan->product->name }}</dd></div>
                <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ ucfirst($loan->status) }}</dd></div>
                <div><dt class="text-gray-500">Principal</dt><dd class="font-medium">₦{{ number_format((float) $loan->principal_amount, 2) }}</dd></div>
                <div><dt class="text-gray-500">Total Repayable</dt><dd class="font-medium">₦{{ number_format((float) $loan->total_repayable, 2) }}</dd></div>
                <div><dt class="text-gray-500">Total Paid</dt><dd class="font-medium">₦{{ number_format($loan->totalPaid(), 2) }}</dd></div>
                <div><dt class="text-gray-500">Outstanding</dt><dd class="font-medium">₦{{ number_format((float) $loan->outstanding_balance, 2) }}</dd></div>
                <div><dt class="text-gray-500">Monthly Installment</dt><dd class="font-medium">₦{{ number_format((float) $loan->monthly_installment, 2) }}</dd></div>
                <div><dt class="text-gray-500">Tenure</dt><dd class="font-medium">{{ $loan->tenure_months }} month(s)</dd></div>
                @if ($loan->disbursed_at)
                    <div><dt class="text-gray-500">Disbursed</dt><dd class="font-medium">{{ $loan->disbursed_at->format('d M Y') }}</dd></div>
                @endif
            </dl>

            @if ($loan->guarantors->isNotEmpty())
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <h4 class="text-xs uppercase text-gray-500 mb-2">Guarantors</h4>
                    <ul class="text-sm space-y-1">
                        @foreach ($loan->guarantors as $guarantor)
                            <li>{{ $guarantor->guarantorMember->full_name }} — {{ ucfirst($guarantor->status) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <livewire:documents.documents-panel :documentable="$loan" :key="'loan-docs-'.$loan->id" />
    </div>
</div>
