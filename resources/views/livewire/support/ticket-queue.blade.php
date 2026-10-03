<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Support Tickets</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex gap-2 text-sm flex-wrap">
                @php
                    $tabs = ['unassigned' => 'Unassigned', 'mine' => 'Assigned to Me', 'all' => 'All Open', 'resolved' => 'Resolved'];
                    if (auth()->user()->can('handle_confidential_complaints')) {
                        $tabs['confidential'] = 'Confidential';
                    }
                @endphp
                @foreach ($tabs as $key => $tabLabel)
                    <button wire:click="setTab('{{ $key }}')" class="px-3 py-1.5 rounded-full border {{ $tab === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-600 border-gray-300' }}">{{ $tabLabel }}</button>
                @endforeach
            </div>

            @can('raise_complaint_on_behalf')
                <x-secondary-button wire:click="openCreate">Log a Complaint</x-secondary-button>
            @endcan
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Ticket</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Assigned</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($tickets as $ticket)
                        <tr wire:key="ticket-{{ $ticket->id }}">
                            <td class="px-4 py-3 font-medium">{{ $ticket->ticket_no }}{{ $ticket->is_confidential ? ' 🔒' : '' }}</td>
                            <td class="px-4 py-3">{{ $ticket->member->full_name }}</td>
                            <td class="px-4 py-3">{{ $ticket->categoryLabel() }}</td>
                            <td class="px-4 py-3">{{ $ticket->subject }}</td>
                            <td class="px-4 py-3">{{ ucwords(str_replace('_', ' ', $ticket->status)) }}</td>
                            <td class="px-4 py-3">{{ $ticket->assignedTo?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('support.tickets.show', $ticket) }}" wire:navigate class="text-emerald-600 hover:underline">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No tickets in this view.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $tickets->links() }}
    </div>

    @if ($showCreateForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Log a Complaint on Behalf of a Member</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="memberSearch" value="Member (name or Staff ID)" />
                        <x-text-input id="memberSearch" wire:model.live.debounce.300ms="memberSearch" type="text" class="mt-1 block w-full" />
                        @if ($this->searchedMembers->isNotEmpty())
                            <div class="mt-1 border border-gray-200 dark:border-gray-600 rounded-md divide-y max-h-40 overflow-y-auto">
                                @foreach ($this->searchedMembers as $m)
                                    <button type="button" wire:click="$set('selectedMemberId', {{ $m->id }})" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700 {{ (string) $selectedMemberId === (string) $m->id ? 'bg-emerald-50 dark:bg-emerald-900/30' : '' }}">
                                        {{ $m->full_name }} ({{ $m->staff_id }})
                                    </button>
                                @endforeach
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('selectedMemberId')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="category" value="Category" />
                        <select id="category" wire:model="category" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="subject" value="Subject" />
                        <x-text-input id="subject" wire:model="subject" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('subject')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="body" value="Details" />
                        <textarea id="body" wire:model="body" rows="4" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-1" />
                    </div>
                    <label class="flex items-start gap-2 text-sm">
                        <input type="checkbox" wire:model="is_confidential" class="mt-0.5 rounded dark:bg-gray-900 border-gray-300 text-emerald-600 shadow-sm">
                        <span>Mark confidential — only the Chairman will see it.</span>
                    </label>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeCreateForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="save" wire:loading.attr="disabled">Submit</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
