<div>
    <h1 class="text-lg font-bold mb-1">Set a New Password</h1>
    <p class="text-sm text-gray-500 mb-6">
        For your security, you must set a new password before continuing. Your current password is your Staff ID —
        your new password must be different from it.
    </p>

    <form wire:submit="submit" class="space-y-4">
        <div>
            <x-input-label for="new_password" value="New Password" />
            <x-text-input id="new_password" wire:model="new_password" type="password" class="mt-1 block w-full" autofocus autocomplete="new-password" />
            <x-input-error :messages="$errors->get('new_password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="new_password_confirmation" value="Confirm New Password" />
            <x-text-input id="new_password_confirmation" wire:model="new_password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <button type="button" wire:click="logout" class="text-sm text-gray-600 underline">Log out instead</button>
            <x-primary-button wire:loading.attr="disabled">Set Password &amp; Continue</x-primary-button>
        </div>
    </form>
</div>
