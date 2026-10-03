<div class="relative" x-data>
    <button wire:click="toggle" class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if ($unreadCount > 0)
            <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-red-600 rounded-full">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    @if ($open)
        <div class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-100 dark:border-gray-700 z-50">
            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                <span class="text-sm font-semibold">Notifications</span>
                @if ($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs text-emerald-600 hover:underline">Mark all read</button>
                @endif
            </div>
            <div class="max-h-96 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($recent as $notification)
                    <a
                        href="{{ $notification->data['url'] ?? '#' }}"
                        wire:navigate
                        wire:click="markAsRead('{{ $notification->id }}')"
                        class="block px-4 py-3 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 {{ $notification->read_at ? '' : 'bg-emerald-50 dark:bg-emerald-900/20' }}"
                    >
                        <p class="font-medium">{{ $notification->data['title'] ?? 'Notification' }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $notification->data['body'] ?? '' }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </a>
                @empty
                    <p class="px-4 py-6 text-sm text-gray-500 text-center">No notifications yet.</p>
                @endforelse
            </div>
            <div class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 text-center">
                <a href="{{ route('notifications.index') }}" wire:navigate class="text-xs text-emerald-600 hover:underline">View all</a>
            </div>
        </div>
    @endif
</div>
