<div>
    <h1 class="text-xl font-bold mb-1">Membership Application Form</h1>
    <p class="text-sm text-gray-500 mb-6">FCE (T) Potiskum Staff Cooperative Society Limited</p>

    <form wire:submit="submit" class="space-y-8">
        {{-- Section A --}}
        <section>
            <h2 class="text-md font-semibold border-b pb-2 mb-4">Section A — Personal Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <x-input-label for="full_name" value="Full Name" />
                    <x-text-input id="full_name" wire:model="full_name" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('full_name')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="date_of_birth" value="Date of Birth" />
                    <x-text-input id="date_of_birth" wire:model="date_of_birth" type="date" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="gender" value="Gender" />
                    <select id="gender" wire:model="gender" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">Select...</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="ippis_number" value="IPPIS Number (optional)" />
                    <x-text-input id="ippis_number" wire:model="ippis_number" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('ippis_number')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="marital_status" value="Marital Status" />
                    <select id="marital_status" wire:model="marital_status" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">Select...</option>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                        <option value="divorced">Divorced</option>
                        <option value="widowed">Widowed</option>
                    </select>
                    <x-input-error :messages="$errors->get('marital_status')" class="mt-1" />
                </div>

                <div class="sm:col-span-2">
                    <x-input-label for="home_address" value="Home Address" />
                    <textarea id="home_address" wire:model="home_address" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('home_address')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="phone_1" value="Phone Number 1" />
                    <x-text-input id="phone_1" wire:model="phone_1" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('phone_1')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="phone_2" value="Phone Number 2 (optional)" />
                    <x-text-input id="phone_2" wire:model="phone_2" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('phone_2')" class="mt-1" />
                </div>

                <div class="sm:col-span-2">
                    <x-input-label for="email" value="Email Address (used for your account login)" />
                    <x-text-input id="email" wire:model="email" type="email" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="password" value="Choose a Password" />
                    <x-text-input id="password" wire:model="password" type="password" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" value="Confirm Password" />
                    <x-text-input id="password_confirmation" wire:model="password_confirmation" type="password" class="mt-1 block w-full" />
                </div>

                <div class="sm:col-span-2">
                    <x-input-label for="photo" value="Passport Photograph (JPEG/PNG, max 2MB)" />
                    <input id="photo" wire:model="photo" type="file" accept="image/png,image/jpeg" class="mt-1 block w-full text-sm" />
                    <x-input-error :messages="$errors->get('photo')" class="mt-1" />
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="mt-2 h-20 w-20 object-cover rounded" alt="Preview">
                    @endif
                </div>
            </div>
        </section>

        {{-- Section B --}}
        <section>
            <h2 class="text-md font-semibold border-b pb-2 mb-4">Section B — Employment Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="department" value="Department / Directorate / Unit" />
                    <x-text-input id="department" wire:model="department" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('department')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="staff_category" value="Staff Category" />
                    <select id="staff_category" wire:model.live="staff_category" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">Select...</option>
                        <option value="senior_staff">Senior Staff</option>
                        <option value="junior_staff">Junior Staff</option>
                    </select>
                    <x-input-error :messages="$errors->get('staff_category')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="staff_id" value="Staff ID Number" />
                    <x-text-input id="staff_id" wire:model="staff_id" type="text" placeholder="{{ $staff_category === 'junior_staff' ? 'JS/1234' : 'SS/1234' }}" class="mt-1 block w-full" />
                    <p class="text-xs text-gray-500 mt-1">
                        @if ($staff_category === 'junior_staff')
                            Format: JS/&lt;number&gt;, e.g. JS/1234
                        @else
                            Format: SS/&lt;number&gt;, e.g. SS/1234
                        @endif
                    </p>
                    <x-input-error :messages="$errors->get('staff_id')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="date_of_first_appointment" value="Date of First Appointment" />
                    <x-text-input id="date_of_first_appointment" wire:model="date_of_first_appointment" type="date" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('date_of_first_appointment')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="employment_status" value="Employment Status" />
                    <select id="employment_status" wire:model="employment_status" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="">Select...</option>
                        <option value="permanent">Permanent</option>
                        <option value="contract">Contract</option>
                        <option value="casual">Casual</option>
                    </select>
                    <x-input-error :messages="$errors->get('employment_status')" class="mt-1" />
                </div>

                <div class="sm:col-span-2">
                    <x-input-label for="rank_grade" value="Present Rank / Cadre / Grade Level" />
                    <x-text-input id="rank_grade" wire:model="rank_grade" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('rank_grade')" class="mt-1" />
                </div>
            </div>
        </section>

        {{-- Section C --}}
        <section>
            <h2 class="text-md font-semibold border-b pb-2 mb-4">Section C — Membership Commitment</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="preferred_monthly_contribution" value="Preferred Monthly Contribution (₦)" />
                    <x-text-input id="preferred_monthly_contribution" wire:model="preferred_monthly_contribution" type="number" step="0.01" class="mt-1 block w-full" />
                    <p class="text-xs text-gray-500 mt-1">Minimum ₦{{ number_format((float) \App\Models\Setting::get('minimum_monthly_contribution', 5000)) }}</p>
                    <x-input-error :messages="$errors->get('preferred_monthly_contribution')" class="mt-1" />
                </div>

                <div>
                    <x-input-label value="Mode of Deduction" />
                    <x-text-input value="Salary Deduction" type="text" class="mt-1 block w-full bg-gray-100 dark:bg-gray-600" disabled />
                </div>
            </div>

            <h3 class="text-sm font-semibold mt-6 mb-3 text-gray-700 dark:text-gray-300">Next of Kin</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="nok_name" value="Name" />
                    <x-text-input id="nok_name" wire:model="nok_name" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('nok_name')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="nok_relationship" value="Relationship" />
                    <x-text-input id="nok_relationship" wire:model="nok_relationship" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('nok_relationship')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="nok_phone" value="Phone Number" />
                    <x-text-input id="nok_phone" wire:model="nok_phone" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('nok_phone')" class="mt-1" />
                </div>

                <div>
                    <x-input-label for="nok_address" value="Address (optional)" />
                    <x-text-input id="nok_address" wire:model="nok_address" type="text" class="mt-1 block w-full" />
                </div>
            </div>
        </section>

        {{-- Section D --}}
        <section>
            <h2 class="text-md font-semibold border-b pb-2 mb-4">Section D — Declaration</h2>
            <label class="flex items-start gap-2">
                <input type="checkbox" wire:model="declaration_accepted" class="mt-1 rounded border-gray-300 text-emerald-600 shadow-sm">
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    I pledge to abide by the rules and regulations of the FCE (T) Potiskum Staff Cooperative Society Limited.
                </span>
            </label>
            <x-input-error :messages="$errors->get('declaration_accepted')" class="mt-1" />

            <div class="mt-4">
                <x-input-label for="declaration_signed_name" value="Type your full name as digital signature" />
                <x-text-input id="declaration_signed_name" wire:model="declaration_signed_name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('declaration_signed_name')" class="mt-1" />
            </div>
        </section>

        <div class="flex items-center justify-between pt-4 border-t">
            <a href="{{ route('login') }}" wire:navigate class="text-sm text-gray-600 underline">Already applied? Log in</a>
            <x-primary-button wire:loading.attr="disabled">
                Submit Application
            </x-primary-button>
        </div>
    </form>
</div>
