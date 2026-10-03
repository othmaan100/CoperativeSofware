<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Announcements</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @forelse ($announcements as $announcement)
            <div wire:key="ann-{{ $announcement->id }}" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold">
                    {{ $announcement->title }}
                    @if ($announcement->is_pinned)
                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pinned</span>
                    @endif
                </h3>
                <p class="text-xs text-gray-500 mt-1">By {{ $announcement->postedBy->name }} on {{ $announcement->created_at->format('d M Y, H:i') }}</p>
                <p class="text-sm mt-3 whitespace-pre-line">{{ $announcement->body }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500">No announcements yet.</p>
        @endforelse

        {{ $announcements->links() }}
    </div>
</div>
