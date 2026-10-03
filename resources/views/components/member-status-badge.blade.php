@props(['status', 'rejected' => false])

@php
    $label = $rejected ? 'Rejected' : ucfirst($status);

    $colors = match (true) {
        $rejected => 'bg-red-100 text-red-800',
        $status === 'active' => 'bg-green-100 text-green-800',
        $status === 'pending' => 'bg-yellow-100 text-yellow-800',
        $status === 'suspended' => 'bg-orange-100 text-orange-800',
        $status === 'dormant' => 'bg-gray-200 text-gray-700',
        $status === 'exited' => 'bg-slate-200 text-slate-700',
        $status === 'deceased' => 'bg-black text-white',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold $colors"]) }}>
    {{ $label }}
</span>
