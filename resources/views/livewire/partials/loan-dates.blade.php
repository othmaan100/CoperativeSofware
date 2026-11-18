{{-- Every stage of a loan with its date and who acted. Expects $loan (Loan, with guarantors.guarantorMember and the *By relations loaded). --}}
@php
    // Imported records only carry the real disbursement date, not a real time of day.
    $fmt = fn ($date) => $date->format($loan->is_legacy_import ? 'd M Y' : 'd M Y, g:i a');
    $treasurerLabel = $loan->status === 'treasurer_rejected' ? 'Rejected' : 'Endorsed';
    $chairmanLabel = $loan->status === 'chairman_declined' ? 'Declined' : 'Authorized';
@endphp
@if (! $loan->is_legacy_import)
    <div><span class="font-medium text-gray-800 dark:text-gray-200">Applied:</span> {{ $loan->applied_at ? $fmt($loan->applied_at) : '—' }}</div>
    @foreach ($loan->guarantors as $guarantor)
        @if ($guarantor->accepted_at)
            <div><span class="font-medium text-gray-800 dark:text-gray-200">Guarantor accepted:</span> {{ $fmt($guarantor->accepted_at) }} — {{ $guarantor->guarantorMember?->full_name }}</div>
        @elseif ($guarantor->declined_at)
            <div><span class="font-medium text-gray-800 dark:text-gray-200">Guarantor declined:</span> {{ $fmt($guarantor->declined_at) }} — {{ $guarantor->guarantorMember?->full_name }}</div>
        @endif
    @endforeach
@endif
@if ($loan->treasurer_reviewed_at)
    <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $treasurerLabel }}:</span> {{ $fmt($loan->treasurer_reviewed_at) }}@if ($loan->treasurerReviewedBy) — {{ $loan->treasurerReviewedBy->name }}@endif</div>
@endif
@if ($loan->chairman_reviewed_at)
    <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $chairmanLabel }}:</span> {{ $fmt($loan->chairman_reviewed_at) }}@if ($loan->chairmanReviewedBy) — {{ $loan->chairmanReviewedBy->name }}@endif</div>
@endif
@if ($loan->disbursed_at)
    <div><span class="font-medium text-gray-800 dark:text-gray-200">Disbursed:</span> {{ $fmt($loan->disbursed_at) }}@if ($loan->disbursedBy && ! $loan->is_legacy_import) — {{ $loan->disbursedBy->name }}@endif</div>
@endif
@if ($loan->defaulted_at)
    <div><span class="font-medium text-gray-800 dark:text-gray-200">Defaulted:</span> {{ $fmt($loan->defaulted_at) }}</div>
@endif
@if ($loan->closed_at)
    {{-- For imported loans already fully repaid, the closing date is simply when the import ran. --}}
    <div><span class="font-medium text-gray-800 dark:text-gray-200">Closed:</span> {{ $loan->closed_at->format('d M Y') }}{{ $loan->is_legacy_import ? ' (when imported)' : '' }}</div>
@endif
