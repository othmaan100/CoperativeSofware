<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h3 class="font-semibold mb-4">Documents</h3>

    @if (session('status'))
        <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-3 py-2 text-sm mb-4">{{ session('status') }}</div>
    @endif

    @if ($canManage)
        <form wire:submit="upload" class="flex flex-wrap items-end gap-3 mb-4 border-b border-gray-100 dark:border-gray-700 pb-4">
            <div class="flex-1 min-w-[160px]">
                <x-input-label for="doc_title" value="Title" />
                <x-text-input id="doc_title" wire:model="title" type="text" placeholder="e.g. National ID Card" class="mt-1 block w-full text-sm" />
                <x-input-error :messages="$errors->get('title')" class="mt-1" />
            </div>
            <div class="flex-1 min-w-[160px]">
                <x-input-label for="doc_file" value="File (PDF, image, or Word doc, max 10MB)" />
                <input id="doc_file" wire:model="file" type="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="mt-1 block w-full text-sm" />
                <x-input-error :messages="$errors->get('file')" class="mt-1" />
            </div>
            <x-primary-button wire:loading.attr="disabled">Upload</x-primary-button>
        </form>
    @endif

    <div class="divide-y divide-gray-100 dark:divide-gray-700">
        @forelse ($documents as $document)
            <div wire:key="doc-{{ $document->id }}" class="flex items-center justify-between py-2 text-sm">
                <div>
                    <p class="font-medium">{{ $document->title }}</p>
                    <p class="text-xs text-gray-500">{{ $document->original_filename }} &middot; {{ $document->humanFileSize() }} &middot; uploaded by {{ $document->uploadedBy->name }} on {{ $document->created_at->format('d M Y') }}</p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('documents.download', $document) }}" class="text-emerald-600 hover:underline">Download</a>
                    @if ($canManage)
                        <button wire:click="delete({{ $document->id }})" wire:confirm="Delete this document? This cannot be undone." class="text-red-700 hover:underline">Delete</button>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 py-2">No documents uploaded yet.</p>
        @endforelse
    </div>
</div>
