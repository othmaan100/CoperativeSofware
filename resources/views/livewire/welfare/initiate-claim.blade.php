<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Welfare Claim — {{ $member->full_name }}</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4 text-sm space-y-1">
            <p>Death benefit amount: <strong>₦{{ number_format($deathBenefitAmount, 2) }}</strong> (fixed by the society's welfare settings)</p>
            @if ($member->nextOfKin->isNotEmpty())
                <p>Recorded next of kin: {{ $member->nextOfKin->first()->name }} ({{ $member->nextOfKin->first()->relationship }}) — {{ $member->nextOfKin->first()->phone }}</p>
            @endif
        </div>

        <form wire:submit="submit" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <div>
                <x-input-label for="date_of_death" value="Date of Death" />
                <x-text-input id="date_of_death" wire:model="date_of_death" type="date" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('date_of_death')" class="mt-1" />
            </div>

            <h3 class="font-semibold pt-2">Beneficiary Details</h3>
            <div>
                <x-input-label for="beneficiary_name" value="Beneficiary Name" />
                <x-text-input id="beneficiary_name" wire:model="beneficiary_name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('beneficiary_name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="beneficiary_relationship" value="Relationship to Member" />
                <x-text-input id="beneficiary_relationship" wire:model="beneficiary_relationship" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('beneficiary_relationship')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="beneficiary_phone" value="Beneficiary Phone" />
                <x-text-input id="beneficiary_phone" wire:model="beneficiary_phone" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('beneficiary_phone')" class="mt-1" />
            </div>

            <h3 class="font-semibold pt-2">Payout Bank Details</h3>
            <div>
                <x-input-label for="bank_name" value="Bank Name" />
                <x-text-input id="bank_name" wire:model="bank_name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('bank_name')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="account_number" value="Account Number" />
                <x-text-input id="account_number" wire:model="account_number" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('account_number')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="account_name" value="Account Name" />
                <x-text-input id="account_name" wire:model="account_name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('account_name')" class="mt-1" />
            </div>

            <div class="flex justify-end">
                <x-primary-button wire:loading.attr="disabled">Submit for Chairman Authorization</x-primary-button>
            </div>
        </form>
    </div>
</div>
