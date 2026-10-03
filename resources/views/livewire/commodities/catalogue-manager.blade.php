<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Commodity Catalogue</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex flex-wrap gap-4 items-end justify-between">
            <div class="flex-1 min-w-[16rem]">
                <x-input-label for="search" value="Search (description, type/brand, pack/unit)" />
                <x-text-input id="search" wire:model.live.debounce.400ms="search" type="text" placeholder="e.g. rice, 50kg bag" class="mt-1 block w-full" />
            </div>
            <x-primary-button wire:click="openCreate">Add Item</x-primary-button>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Type/Brand</th>
                        <th class="px-4 py-3">Pack/Unit</th>
                        <th class="px-4 py-3">Request Unit Options</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($items as $item)
                        <tr wire:key="item-{{ $item->id }}">
                            <td class="px-4 py-3">{{ $item->description }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $item->type_brand }}</td>
                            <td class="px-4 py-3">{{ $item->pack_unit }}</td>
                            <td class="px-4 py-3 text-gray-500">
                                @if ($item->hasUnitOptions())
                                    {{ $item->unitOptionsAsString() }}
                                @else
                                    <span class="text-xs text-amber-600">Not set — request form uses free text</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if ($item->created_from_request_line_id)
                                    <span class="ml-1 text-xs text-emerald-600">(auto-added)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button wire:click="openEdit({{ $item->id }})" class="text-emerald-600 hover:underline">Edit</button>
                                <button wire:click="toggleActive({{ $item->id }})" class="text-gray-600 hover:underline">{{ $item->is_active ? 'Deactivate' : 'Activate' }}</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">{{ $search !== '' ? 'No catalogue items match your search.' : 'No catalogue items yet.' }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $items->links() }}
    </div>

    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">{{ $editingId ? 'Edit' : 'Add' }} Catalogue Item</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="description" value="Description" />
                        <x-text-input id="description" wire:model="description" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="type_brand" value="Type / Brand" />
                        <x-text-input id="type_brand" wire:model="type_brand" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('type_brand')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="pack_unit" value="Pack / Unit" />
                        <x-text-input id="pack_unit" wire:model="pack_unit" type="text" class="mt-1 block w-full" />
                        <p class="text-xs text-gray-500 mt-1">The item's own standard pack size, e.g. "50kg Bag" or "Carton".</p>
                        <x-input-error :messages="$errors->get('pack_unit')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="unit_options" value="Request Unit Options (optional)" />
                        <x-text-input id="unit_options" wire:model="unit_options" type="text" placeholder="e.g. Full bag, Half bag, Quarter bag" class="mt-1 block w-full" />
                        <p class="text-xs text-gray-500 mt-1">
                            Comma-separated list of units a member may choose when requesting this item. Leave blank
                            to let members type their own unit instead.
                        </p>
                        <x-input-error :messages="$errors->get('unit_options')" class="mt-1" />
                    </div>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-emerald-600" />
                        Active
                    </label>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="save" wire:loading.attr="disabled">Save</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
