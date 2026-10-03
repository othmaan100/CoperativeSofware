<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $ticket->ticket_no }} — {{ $ticket->subject }}</h2>
            @if ($ticket->is_confidential)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">Confidential</span>
            @endif
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 flex flex-wrap items-center gap-6 text-sm">
            <div><p class="text-gray-500">Member</p><p class="font-medium">{{ $ticket->member->full_name }}</p></div>
            <div><p class="text-gray-500">Category</p><p class="font-medium">{{ $ticket->categoryLabel() }}</p></div>
            <div><p class="text-gray-500">Status</p><p class="font-medium">{{ ucwords(str_replace('_', ' ', $ticket->status)) }}</p></div>
            <div><p class="text-gray-500">Assigned To</p><p class="font-medium">{{ $ticket->assignedTo?->name ?? 'Unassigned' }}</p></div>

            @if ($canHandle)
                <div class="ml-auto flex gap-2">
                    @if (! $ticket->assigned_to)
                        <x-secondary-button wire:click="claim">Claim</x-secondary-button>
                    @endif
                    @if ($ticket->status !== 'resolved')
                        <x-primary-button wire:click="resolve" wire:confirm="Mark this ticket resolved?">Resolve</x-primary-button>
                    @endif
                </div>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            @forelse ($ticket->messages as $message)
                <div wire:key="msg-{{ $message->id }}" class="{{ $message->user_id === auth()->id() ? 'ml-8' : 'mr-8' }}">
                    <div class="rounded-lg p-3 text-sm {{ $message->user_id === auth()->id() ? 'bg-emerald-50 dark:bg-emerald-900/30' : 'bg-gray-50 dark:bg-gray-700' }}">
                        <p class="whitespace-pre-line">{{ $message->body }}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $message->user->name }} &middot; {{ $message->created_at->format('d M Y, H:i') }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">No messages yet.</p>
            @endforelse
        </div>

        @if ($canHandle || $isOwner)
            <form wire:submit="reply" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <x-input-label for="replyBody" value="Reply" />
                <textarea id="replyBody" wire:model="replyBody" rows="3" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('replyBody')" class="mt-1" />
                <div class="flex justify-end mt-3">
                    <x-primary-button wire:loading.attr="disabled">Send Reply</x-primary-button>
                </div>
            </form>
        @endif
    </div>
</div>
