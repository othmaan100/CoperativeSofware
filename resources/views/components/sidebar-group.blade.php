@props(['label', 'active' => false])

<div x-data="{ open: @js($active) }">
    <button
        type="button"
        @click="open = !open"
        class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md text-sm font-medium transition {{ $active ? 'text-emerald-800 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }} hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-gray-700/60 dark:hover:text-white"
    >
        <span>{{ $label }}</span>
        <svg class="h-4 w-4 shrink-0 transition-transform duration-150" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        style="display: none;"
        class="mt-1 ml-3 pl-3 border-l border-slate-200 dark:border-gray-700 space-y-1"
    >
        {{ $slot }}
    </div>
</div>
