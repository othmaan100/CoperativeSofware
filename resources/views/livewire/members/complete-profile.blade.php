<div>
    <h1 class="text-lg font-bold mb-1">Complete Your Profile</h1>
    <p class="text-sm text-gray-500 mb-6">
        A few details were missing from your membership record. Please fill them in before continuing.
    </p>

    <form wire:submit="submit" class="space-y-4">
        @if (in_array('phone_1', $missing))
            <div>
                <x-input-label for="phone_1" value="Phone Number" />
                <x-text-input id="phone_1" wire:model="phone_1" type="text" class="mt-1 block w-full" autofocus />
                <x-input-error :messages="$errors->get('phone_1')" class="mt-1" />
            </div>
        @endif

        @if (in_array('email', $missing))
            <div>
                <x-input-label for="email" value="Email Address" />
                <x-text-input id="email" wire:model="email" type="email" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
        @endif

        @if (in_array('gender', $missing))
            <div>
                <x-input-label for="gender" value="Gender" />
                <select id="gender" wire:model="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select...</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-1" />
            </div>
        @endif

        @if (in_array('date_of_birth', $missing))
            <div>
                <x-input-label for="date_of_birth" value="Date of Birth" />
                <x-text-input id="date_of_birth" wire:model="date_of_birth" type="date" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
            </div>
        @endif

        @if (in_array('marital_status', $missing))
            <div>
                <x-input-label for="marital_status" value="Marital Status" />
                <select id="marital_status" wire:model="marital_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select...</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>
                <x-input-error :messages="$errors->get('marital_status')" class="mt-1" />
            </div>
        @endif

        @if (in_array('home_address', $missing))
            <div>
                <x-input-label for="home_address" value="Home Address" />
                <textarea id="home_address" wire:model="home_address" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('home_address')" class="mt-1" />
            </div>
        @endif

        @if (in_array('nok_name', $missing) || in_array('nok_relationship', $missing) || in_array('nok_phone', $missing))
            <div class="border-t pt-4 mt-4">
                <h2 class="text-sm font-semibold text-gray-700 mb-2">Next of Kin</h2>

                @if (in_array('nok_name', $missing))
                    <div class="mb-3">
                        <x-input-label for="nok_name" value="Next of Kin Name" />
                        <x-text-input id="nok_name" wire:model="nok_name" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('nok_name')" class="mt-1" />
                    </div>
                @endif

                @if (in_array('nok_relationship', $missing))
                    <div class="mb-3">
                        <x-input-label for="nok_relationship" value="Relationship" />
                        <x-text-input id="nok_relationship" wire:model="nok_relationship" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('nok_relationship')" class="mt-1" />
                    </div>
                @endif

                @if (in_array('nok_phone', $missing))
                    <div>
                        <x-input-label for="nok_phone" value="Next of Kin Phone" />
                        <x-text-input id="nok_phone" wire:model="nok_phone" type="text" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('nok_phone')" class="mt-1" />
                    </div>
                @endif
            </div>
        @endif

        <div class="flex items-center justify-between pt-2">
            <button type="button" wire:click="logout" class="text-sm text-gray-600 underline">Log out instead</button>
            <x-primary-button wire:loading.attr="disabled">Save &amp; Continue</x-primary-button>
        </div>
    </form>
</div>
