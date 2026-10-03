<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Commodity Cycles</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @can('manage_commodity_cycles')
            <div class="flex justify-end">
                <x-primary-button wire:click="openCreate">Open New Cycle</x-primary-button>
            </div>
        @endcan

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Deadline</th>
                        <th class="px-4 py-3">Requests</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($cycles as $cycle)
                        <tr wire:key="cycle-{{ $cycle->id }}">
                            <td class="px-4 py-3 font-medium">{{ $cycle->name }}</td>
                            <td class="px-4 py-3">{{ $cycle->request_deadline->format('d M Y') }}</td>
                            <td class="px-4 py-3">{{ $cycle->requests_count }}</td>
                            <td class="px-4 py-3">{{ ucwords(str_replace('_', ' ', $cycle->status)) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('commodities.cycles.show', $cycle) }}" wire:navigate class="text-emerald-600 hover:underline">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No commodity cycles yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $cycles->links() }}
    </div>

    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Open a New Commodity Cycle</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="name" value="Cycle Name" />
                        <x-text-input id="name" wire:model="name" type="text" placeholder="e.g. 2026 Q4 Commodity Cycle" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="request_deadline" value="Request Deadline" />
                        <x-text-input id="request_deadline" wire:model="request_deadline" type="date" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('request_deadline')" class="mt-1" />
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="create" wire:loading.attr="disabled">Open Cycle</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
