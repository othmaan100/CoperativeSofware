<div @if ($announcements->isEmpty()) hidden @endif>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-slate-100 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Announcements</h3>
            <a href="{{ route('announcements.index') }}" wire:navigate class="text-sm text-emerald-600 hover:underline">View all</a>
        </div>
        <div class="space-y-3">
            @foreach ($announcements as $announcement)
                <div wire:key="dash-ann-{{ $announcement->id }}" class="border-l-4 {{ $announcement->is_pinned ? 'border-yellow-400' : 'border-slate-200 dark:border-gray-600' }} pl-3">
                    <p class="font-medium text-sm">{{ $announcement->title }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ \Illuminate\Support\Str::limit($announcement->body, 140) }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ $announcement->created_at->format('d M Y') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
