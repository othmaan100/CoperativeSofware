{{-- Every stage of a savings withdrawal request with its date and who acted. Expects $req (WithdrawalRequest). --}}
@php
    // Imported records only carry the real withdrawal date, not a real time of day.
    $fmt = fn ($date) => $date->format($req->is_legacy_import ? 'd M Y' : 'd M Y, g:i a');
    $treasurerLabel = $req->status === 'treasurer_rejected' ? 'Rejected' : 'Endorsed';
    $chairmanLabel = $req->status === 'chairman_declined' ? 'Declined' : 'Authorized';
@endphp
<div><span class="font-medium text-gray-800 dark:text-gray-200">Requested:</span> {{ $req->requested_at ? $fmt($req->requested_at) : '—' }}</div>
@if ($req->treasurer_reviewed_at && ! $req->is_legacy_import)
    <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $treasurerLabel }}:</span> {{ $fmt($req->treasurer_reviewed_at) }}@if ($req->treasurerReviewedBy) — {{ $req->treasurerReviewedBy->name }}@endif</div>
@endif
@if ($req->chairman_reviewed_at)
    <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $chairmanLabel }}:</span> {{ $fmt($req->chairman_reviewed_at) }}@if ($req->chairmanReviewedBy) — {{ $req->chairmanReviewedBy->name }}@endif</div>
@endif
@if ($req->disbursed_at)
    <div><span class="font-medium text-gray-800 dark:text-gray-200">Disbursed:</span> {{ $fmt($req->disbursed_at) }}@if ($req->disbursedBy) — {{ $req->disbursedBy->name }}@endif</div>
@endif
