<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Profile</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Locked / official fields --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold">Membership Details (locked — contact Super Admin to change)</h3>
                <x-member-status-badge :status="$member->status" />
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                <div><dt class="text-gray-500">Membership No.</dt><dd class="font-medium">{{ $member->membership_no ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Department</dt><dd class="font-medium">{{ $member->department }}</dd></div>
                <div><dt class="text-gray-500">Staff ID</dt><dd class="font-medium">{{ $member->staff_id }}</dd></div>
                <div><dt class="text-gray-500">Rank / Grade</dt><dd class="font-medium">{{ $member->rank_grade ?? '—' }}</dd></div>
                <div>
                    <dt class="text-gray-500">Approved Monthly Contribution</dt>
                    <dd class="font-medium">
                        ₦{{ number_format((float) $member->approved_monthly_contribution, 2) }}
                        @if ($member->status === 'active' && ! $this->pendingContributionChangeRequest)
                            <button wire:click="openContributionChangeModal" class="ml-2 text-xs text-emerald-600 hover:underline">Request Change</button>
                        @endif
                    </dd>
                </div>
            </dl>

            @if ($this->pendingContributionChangeRequest)
                <div class="mt-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md px-4 py-3 text-sm">
                    Contribution change requested: ₦{{ number_format((float) $this->pendingContributionChangeRequest->current_amount, 2) }}
                    &rarr; ₦{{ number_format((float) $this->pendingContributionChangeRequest->requested_amount, 2) }}
                    — awaiting Treasurer review.
                </div>
            @endif
        </div>

        {{-- Pending change requests --}}
        @if ($this->pendingChangeRequests->isNotEmpty())
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <h3 class="font-semibold mb-3 text-yellow-800">Pending Change Requests (awaiting Secretary review)</h3>
                <ul class="text-sm space-y-1">
                    @foreach ($this->pendingChangeRequests as $cr)
                        <li>{{ $cr->fieldLabel() }}: <span class="line-through text-gray-500">{{ $cr->old_value }}</span> &rarr; {{ $cr->new_value }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Editable fields --}}
        <form wire:submit="submitChanges" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-6">
            <h3 class="font-semibold">Personal & Contact Information</h3>
            <p class="text-xs text-gray-500 -mt-4">Changes here are submitted to the Secretary for approval before they take effect.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="full_name" value="Full Name" />
                    <x-text-input id="full_name" wire:model="full_name" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('full_name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="date_of_birth" value="Date of Birth" />
                    <x-text-input id="date_of_birth" wire:model="date_of_birth" type="date" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="gender" value="Gender" />
                    <select id="gender" wire:model="gender" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="ippis_number" value="IPPIS Number" />
                    <x-text-input id="ippis_number" wire:model="ippis_number" type="text" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="marital_status" value="Marital Status" />
                    <select id="marital_status" wire:model="marital_status" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                        <option value="widowed">Widowed</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="employment_status" value="Employment Status" />
                    <select id="employment_status" wire:model="employment_status" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="permanent">Permanent</option>
                        <option value="contract">Contract</option>
                        <option value="casual">Casual</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <x-input-label for="home_address" value="Home Address" />
                    <textarea id="home_address" wire:model="home_address" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div>
                    <x-input-label for="phone_1" value="Phone Number 1" />
                    <x-text-input id="phone_1" wire:model="phone_1" type="text" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="phone_2" value="Phone Number 2" />
                    <x-text-input id="phone_2" wire:model="phone_2" type="text" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="email" value="Email Address" />
                    <x-text-input id="email" wire:model="email" type="email" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="date_of_first_appointment" value="Date of First Appointment" />
                    <x-text-input id="date_of_first_appointment" wire:model="date_of_first_appointment" type="date" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="preferred_monthly_contribution" value="Preferred Monthly Contribution (₦)" />
                    <x-text-input id="preferred_monthly_contribution" wire:model="preferred_monthly_contribution" type="number" step="0.01" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="photo" value="Replace Passport Photograph" />
                    <input id="photo" wire:model="photo" type="file" accept="image/png,image/jpeg" class="mt-1 block w-full text-sm" />
                    <x-input-error :messages="$errors->get('photo')" class="mt-1" />
                </div>
            </div>

            <h3 class="font-semibold pt-2">Next of Kin</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="nok_name" value="Name" />
                    <x-text-input id="nok_name" wire:model="nok_name" type="text" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="nok_relationship" value="Relationship" />
                    <x-text-input id="nok_relationship" wire:model="nok_relationship" type="text" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="nok_phone" value="Phone" />
                    <x-text-input id="nok_phone" wire:model="nok_phone" type="text" class="mt-1 block w-full" />
                </div>
                <div>
                    <x-input-label for="nok_address" value="Address" />
                    <x-text-input id="nok_address" wire:model="nok_address" type="text" class="mt-1 block w-full" />
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <x-primary-button wire:loading.attr="disabled">Save Changes</x-primary-button>
            </div>
        </form>

        {{-- Exit / withdrawal --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-3">Exit / Withdrawal</h3>
            @if ($member->exit_requested_at && ! $member->exited_at)
                <p class="text-sm text-yellow-700">
                    Exit requested on {{ $member->exit_requested_at->format('d M Y') }}.
                    Treasurer clearance: {{ $member->exit_treasurer_cleared ? 'Cleared' : 'Pending' }}.
                </p>
            @elseif ($member->exited_at)
                <p class="text-sm text-gray-600">You exited the society on {{ $member->exited_at->format('d M Y') }}.</p>
            @elseif (in_array($member->status, ['active', 'suspended', 'dormant']))
                <form wire:submit="requestExit" class="space-y-3">
                    <x-input-label for="exit_reason" value="Reason for exit" />
                    <textarea id="exit_reason" wire:model="exit_reason" rows="2" class="block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('exit_reason')" class="mt-1" />
                    <x-danger-button wire:loading.attr="disabled" wire:confirm="Are you sure you want to request exit from the society?">
                        Request Exit
                    </x-danger-button>
                </form>
            @else
                <p class="text-sm text-gray-500">Exit is not applicable for your current status.</p>
            @endif
        </div>

        <livewire:documents.documents-panel :documentable="$member" :key="'my-docs-'.$member->id" />
    </div>

    @if ($showContributionChangeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Request Contribution Change</h3>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="new_contribution_amount" value="New Monthly Contribution (₦)" />
                        <x-text-input id="new_contribution_amount" wire:model="new_contribution_amount" type="number" step="0.01" class="mt-1 block w-full" />
                        <p class="text-xs text-gray-500 mt-1">Current: ₦{{ number_format((float) $member->approved_monthly_contribution, 2) }}</p>
                        <x-input-error :messages="$errors->get('new_contribution_amount')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="contribution_change_reason" value="Reason (optional)" />
                        <textarea id="contribution_change_reason" wire:model="contribution_change_reason" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <p class="text-xs text-gray-500">This request goes to the Treasurer for review. Your contribution amount only changes once approved.</p>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeContributionChangeModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="requestContributionChange" wire:loading.attr="disabled">Submit</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
