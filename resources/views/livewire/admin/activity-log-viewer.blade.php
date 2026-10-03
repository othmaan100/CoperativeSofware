<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Activity Log</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <x-input-label for="module" value="Module" />
                    <select id="module" wire:model.live="module" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All modules</option>
                        @foreach ($modules as $m)
                            <option value="{{ $m }}">{{ ucfirst(str_replace('_', ' ', $m)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="causer_id" value="Actor" />
                    <select id="causer_id" wire:model.live="causer_id" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All users</option>
                        @foreach ($causers as $causer)
                            <option value="{{ $causer->id }}">{{ $causer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label for="date_from" value="From" />
                    <x-text-input id="date_from" wire:model.live="date_from" type="date" class="mt-1 block w-full text-sm" />
                </div>
                <div>
                    <x-input-label for="date_to" value="To" />
                    <x-text-input id="date_to" wire:model.live="date_to" type="date" class="mt-1 block w-full text-sm" />
                </div>
                <div>
                    <x-input-label for="search" value="Search Description" />
                    <x-text-input id="search" wire:model.live.debounce.400ms="search" type="text" placeholder="e.g. loan, disbursed, John" class="mt-1 block w-full text-sm" />
                </div>
            </div>
            <div class="flex justify-end mt-3">
                <button wire:click="resetFilters" class="text-xs text-gray-500 hover:underline">Clear filters</button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">When</th>
                        <th class="px-4 py-3">Actor</th>
                        <th class="px-4 py-3">Action</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($logs as $log)
                        <tr wire:key="log-{{ $log->id }}">
                            <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                            <td class="px-4 py-3">{{ $log->causer_name ?? 'System' }}</td>
                            <td class="px-4 py-3"><code class="text-xs bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded">{{ $log->action }}</code></td>
                            <td class="px-4 py-3">{{ $log->description }}</td>
                            <td class="px-4 py-3 text-gray-500 text-xs">
                                @if ($log->subject_type)
                                    {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">{{ $log->ip_address }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No activity recorded for this filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $logs->links() }}
    </div>
</div>
