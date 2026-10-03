@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-3 py-2 rounded-md text-sm font-semibold bg-emerald-50 text-emerald-800 border-l-4 border-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-500'
            : 'flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-slate-600 border-l-4 border-transparent hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-gray-700/60 dark:hover:text-white transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
