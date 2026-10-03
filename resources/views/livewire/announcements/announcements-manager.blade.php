<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Announcements</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex justify-end">
            <x-primary-button wire:click="openCreate">Post Announcement</x-primary-button>
        </div>

        <div class="space-y-4">
            @forelse ($announcements as $announcement)
                <div wire:key="ann-{{ $announcement->id }}" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold">
                                {{ $announcement->title }}
                                @if ($announcement->is_pinned)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pinned</span>
                                @endif
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">By {{ $announcement->postedBy->name }} on {{ $announcement->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0 text-sm">
                            <button wire:click="openEdit({{ $announcement->id }})" class="text-emerald-600 hover:underline">Edit</button>
                            <button wire:click="delete({{ $announcement->id }})" wire:confirm="Delete this announcement?" class="text-red-700 hover:underline">Delete</button>
                        </div>
                    </div>
                    <p class="text-sm mt-3 whitespace-pre-line">{{ $announcement->body }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">No announcements yet.</p>
            @endforelse
        </div>

        {{ $announcements->links() }}
    </div>

    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">{{ $editingId ? 'Edit' : 'Post' }} Announcement</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" wire:model="title" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="body" value="Message" />
                        <textarea id="body" wire:model="body" rows="5" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-1" />
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="is_pinned" class="rounded dark:bg-gray-900 border-gray-300 text-emerald-600 shadow-sm">
                        Pin to the top of the board
                    </label>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="save" wire:loading.attr="disabled">{{ $editingId ? 'Save' : 'Post' }}</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
