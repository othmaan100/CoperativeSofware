<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Tickets</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="flex justify-end">
            <x-primary-button wire:click="openCreate">Raise a Ticket</x-primary-button>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Ticket</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Raised</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($tickets as $ticket)
                        <tr wire:key="ticket-{{ $ticket->id }}">
                            <td class="px-4 py-3 font-medium">{{ $ticket->ticket_no }}</td>
                            <td class="px-4 py-3">{{ $ticket->categoryLabel() }}{{ $ticket->is_confidential ? ' 🔒' : '' }}</td>
                            <td class="px-4 py-3">{{ $ticket->subject }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ match($ticket->status) {
                                    'resolved' => 'bg-green-100 text-green-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-yellow-100 text-yellow-800',
                                } }}">
                                    {{ ucwords(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ $ticket->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('support.tickets.show', $ticket) }}" wire:navigate class="text-emerald-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No tickets yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $tickets->links() }}
    </div>

    @if ($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Raise a Ticket</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="category" value="Category" />
                        <select id="category" wire:model="category" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Any staff member can pick this up, regardless of category.</p>
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
                        <span>Mark confidential (e.g. a complaint about a specific staff member) — only the Chairman will see it.</span>
                    </label>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="save" wire:loading.attr="disabled">Submit</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
