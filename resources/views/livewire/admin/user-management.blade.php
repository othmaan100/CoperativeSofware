<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">User Management</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[12rem]">
                <x-input-label for="search" value="Search (name, email, Staff ID)" />
                <x-text-input id="search" wire:model.live.debounce.400ms="search" type="text" class="mt-1 block w-full" />
            </div>
            <div class="min-w-[10rem]">
                <x-input-label for="roleFilter" value="Role" />
                <select id="roleFilter" wire:model.live="roleFilter" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                    <option value="">All roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ ucwords(str_replace('_', ' ', $role)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Staff ID</th>
                        <th class="px-4 py-3">Roles</th>
                        <th class="px-4 py-3">Password Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td class="px-4 py-3 font-medium">
                                {{ $user->name }}
                                @if ($user->id === auth()->id())
                                    <span class="text-xs text-gray-400">(you)</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->member?->staff_id ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @foreach ($user->roles as $role)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-3">
                                @if ($user->must_change_password)
                                    <span class="text-orange-600">Must change at next login</span>
                                @else
                                    <span class="text-green-700">OK</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if ($user->id !== auth()->id())
                                    <button wire:click="openChangePassword({{ $user->id }})" class="text-emerald-600 hover:underline">Change Password</button>
                                @else
                                    <a href="{{ route('profile') }}" wire:navigate class="text-gray-500 hover:underline">Change your own on Profile</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>

    @if ($activeUserId && $activeUser)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-1">Change Password</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $activeUser?->name }} ({{ $activeUser?->email }})</p>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="new_password" value="New Password" />
                        <x-text-input id="new_password" wire:model="new_password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('new_password')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="new_password_confirmation" value="Confirm New Password" />
                        <x-text-input id="new_password_confirmation" wire:model="new_password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    </div>
                    <label class="flex items-start gap-2">
                        <input type="checkbox" wire:model="require_change" class="mt-1 rounded border-gray-300 text-emerald-600 shadow-sm">
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            Require this user to set their own password the next time they log in.
                        </span>
                    </label>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="changePassword" wire:loading.attr="disabled">Update Password</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
