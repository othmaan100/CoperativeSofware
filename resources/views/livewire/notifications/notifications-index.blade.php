<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Notifications</h2>
            <button wire:click="markAllAsRead" class="text-sm text-emerald-600 hover:underline">Mark all read</button>
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-3">
        @forelse ($notifications as $notification)
            <div wire:key="notif-{{ $notification->id }}" class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex items-start justify-between gap-4 {{ $notification->read_at ? '' : 'border-l-4 border-emerald-500' }}">
                <div>
                    <p class="font-medium text-sm">{{ $notification->data['title'] ?? 'Notification' }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $notification->data['body'] ?? '' }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="flex items-center gap-3 shrink-0 text-sm">
                    @if (! empty($notification->data['url']))
                        <a href="{{ $notification->data['url'] }}" wire:navigate wire:click="markAsRead('{{ $notification->id }}')" class="text-emerald-600 hover:underline">Open</a>
                    @endif
                    @unless ($notification->read_at)
                        <button wire:click="markAsRead('{{ $notification->id }}')" class="text-gray-500 hover:underline">Mark read</button>
                    @endunless
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">No notifications yet.</p>
        @endforelse

        {{ $notifications->links() }}
    </div>
</div>
