<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Members Directory</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="flex flex-wrap gap-2 text-sm">
            @foreach (['all' => 'All', 'active' => 'Active', 'pending' => 'Pending', 'rejected' => 'Rejected', 'suspended' => 'Suspended', 'dormant' => 'Dormant', 'exited' => 'Exited', 'deceased' => 'Deceased'] as $key => $label)
                <button
                    wire:click="$set('status', '{{ $key }}')"
                    class="px-3 py-1.5 rounded-full border {{ $status === $key ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-600 border-gray-300' }}"
                >{{ $label }}</button>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[12rem]">
                <x-input-label for="search" value="Search (name, staff ID, membership/application no.)" />
                <x-text-input id="search" wire:model.live.debounce.400ms="search" type="text" class="mt-1 block w-full" />
            </div>
            <div class="min-w-[10rem]">
                <x-input-label for="department" value="Department" />
                <select id="department" wire:model.live="department" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="">All</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
            </div>
            <x-secondary-button wire:click="exportCsv">Export CSV</x-secondary-button>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Membership / App No.</th>
                        <th class="px-4 py-3">Department</th>
                        <th class="px-4 py-3">Staff ID</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($members as $member)
                        <tr wire:key="member-{{ $member->id }}">
                            <td class="px-4 py-3 font-medium">{{ $member->full_name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $member->membership_no ?? $member->application_no }}</td>
                            <td class="px-4 py-3">{{ $member->department }}</td>
                            <td class="px-4 py-3">{{ $member->staff_id }}</td>
                            <td class="px-4 py-3"><x-member-status-badge :status="$member->status" :rejected="(bool) $member->rejected_at" /></td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('members.show', $member) }}" wire:navigate class="text-emerald-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No members found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $members->links() }}
    </div>
</div>
