<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Staff Accounts</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-md px-4 py-3 text-sm">
            Correct a staff member's <strong>Staff ID</strong> (they log in with it) or <strong>reset a forgotten password</strong>.
            After a reset the member must choose their own password the next time they log in.
            Accounts of officials (Chairman, Treasurer, Secretary, etc.) can only be changed by the Super Admin.
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <x-input-label for="search" value="Search (name, Staff ID, membership no., email)" />
            <x-text-input id="search" wire:model.live.debounce.400ms="search" type="text" class="mt-1 block w-full" />
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Staff ID</th>
                        <th class="px-4 py-3">Membership No.</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Password</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($members as $member)
                        <tr wire:key="staff-{{ $member->id }}">
                            <td class="px-4 py-3 font-medium">
                                {{ $member->full_name }}
                                @if ($member->user_id === auth()->id())
                                    <span class="text-xs text-gray-400">(you)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-mono">{{ $member->staff_id }}</td>
                            <td class="px-4 py-3">{{ $member->membership_no ?? '—' }}</td>
                            <td class="px-4 py-3">{{ ucwords(str_replace('_', ' ', $member->status)) }}</td>
                            <td class="px-4 py-3">
                                @if (! $member->user)
                                    <span class="text-gray-400">No login account</span>
                                @elseif ($member->user->must_change_password)
                                    <span class="text-orange-600">Must change at next login</span>
                                @else
                                    <span class="text-green-700">Set by member</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                @if ($this->canManage($member))
                                    <button wire:click="openStaffId({{ $member->id }})" class="text-emerald-600 hover:underline">Edit Staff ID</button>
                                    @if ($member->user)
                                        <button wire:click="openPassword({{ $member->id }})" class="text-red-700 hover:underline">Reset Password</button>
                                    @endif
                                @elseif ($member->user_id === auth()->id())
                                    <a href="{{ route('profile') }}" wire:navigate class="text-gray-500 hover:underline">Use your Profile page</a>
                                @else
                                    <span class="text-xs text-gray-400">Official — Super Admin only</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No staff members found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $members->links() }}
    </div>

    @if ($activeMember && $mode === 'staff_id')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Edit Staff ID</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activeMember->full_name }} — current Staff ID <span class="font-mono">{{ $activeMember->staff_id }}</span></p>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="staff_id" value="New Staff ID" />
                        <x-text-input id="staff_id" wire:model="staff_id" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('staff_id')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="staff_id_reason" value="Reason for the change" />
                        <x-text-input id="staff_id_reason" wire:model="staff_id_reason" type="text" class="mt-1 block w-full" placeholder="e.g. Typo when imported; new ID issued by the College" />
                        <x-input-error :messages="$errors->get('staff_id_reason')" class="mt-1" />
                    </div>
                    <p class="text-xs text-gray-500">The member will log in with the new Staff ID straight away. Their password does not change and their membership number stays the same.</p>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="saveStaffId" wire:loading.attr="disabled">Save Staff ID</x-primary-button>
                </div>
            </div>
        </div>
    @endif

    @if ($activeMember && $mode === 'password')
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Reset Password</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activeMember->full_name }} — Staff ID <span class="font-mono">{{ $activeMember->staff_id }}</span></p>

                <div class="space-y-3">
                    <label class="flex items-start gap-2">
                        <input type="radio" wire:model.live="password_method" value="staff_id" class="mt-1 border-gray-300 text-emerald-600 shadow-sm">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Reset to their Staff ID <span class="font-mono">({{ $activeMember->staff_id }})</span></span>
                    </label>
                    <label class="flex items-start gap-2">
                        <input type="radio" wire:model.live="password_method" value="custom" class="mt-1 border-gray-300 text-emerald-600 shadow-sm">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Set a temporary password</span>
                    </label>
                    <x-input-error :messages="$errors->get('password_method')" class="mt-1" />

                    @if ($password_method === 'custom')
                        <div>
                            <x-input-label for="new_password" value="Temporary Password" />
                            <x-text-input id="new_password" wire:model="new_password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('new_password')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="new_password_confirmation" value="Confirm Temporary Password" />
                            <x-text-input id="new_password_confirmation" wire:model="new_password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        </div>
                    @endif

                    <p class="text-xs text-gray-500">The member must choose their own new password the next time they log in.</p>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-danger-button wire:click="resetPassword" wire:loading.attr="disabled">Reset Password</x-danger-button>
                </div>
            </div>
        </div>
    @endif
</div>
