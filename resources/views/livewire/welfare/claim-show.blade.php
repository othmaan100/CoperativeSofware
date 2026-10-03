<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Welfare Claim {{ $claim->claim_no }}</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-lg">{{ $claim->member->full_name }}</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ match($claim->status) {
                    'disbursed' => 'bg-green-100 text-green-800',
                    'chairman_authorized' => 'bg-blue-100 text-blue-800',
                    'chairman_declined' => 'bg-red-100 text-red-800',
                    default => 'bg-yellow-100 text-yellow-800',
                } }}">
                    {{ ucwords(str_replace('_', ' ', $claim->status)) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                <div class="text-gray-500">Date of Death</div>
                <div>{{ $claim->date_of_death->format('d M Y') }}</div>

                <div class="text-gray-500">Death Benefit Amount</div>
                <div class="font-semibold">₦{{ number_format((float) $claim->amount, 2) }}</div>

                <div class="text-gray-500">Beneficiary</div>
                <div>{{ $claim->beneficiary_name }} ({{ $claim->beneficiary_relationship }}) — {{ $claim->beneficiary_phone }}</div>

                <div class="text-gray-500">Payout Account</div>
                <div>{{ $claim->account_name }} — {{ $claim->account_number }} ({{ $claim->bank_name }})</div>

                <div class="text-gray-500">Raised By</div>
                <div>{{ $claim->initiatedBy->name }} on {{ $claim->created_at->format('d M Y') }}</div>

                @if ($claim->chairmanReviewedBy)
                    <div class="text-gray-500">{{ $claim->status === 'chairman_declined' ? 'Declined By' : 'Authorized By' }}</div>
                    <div>{{ $claim->chairmanReviewedBy->name }} on {{ $claim->chairman_reviewed_at->format('d M Y') }}</div>
                @endif

                @if ($claim->chairman_note)
                    <div class="text-gray-500">Chairman Note</div>
                    <div>{{ $claim->chairman_note }}</div>
                @endif

                @if ($claim->disbursedBy)
                    <div class="text-gray-500">Disbursed By</div>
                    <div>{{ $claim->disbursedBy->name }} on {{ $claim->disbursed_at->format('d M Y') }}</div>
                @endif

                @if ($claim->payment_reference)
                    <div class="text-gray-500">Payment Reference</div>
                    <div>{{ $claim->payment_reference }}</div>
                @endif
            </div>

            <p class="text-xs text-gray-500 border-t pt-3">Welfare fund balance: ₦{{ number_format($fundBalance, 2) }}</p>

            @can('authorize_welfare_claim')
                @if ($claim->status === 'pending')
                    <div class="flex justify-end gap-2 border-t pt-4">
                        <x-secondary-button wire:click="openDeclineForm">Decline</x-secondary-button>
                        <x-primary-button wire:click="authorizeClaim" wire:confirm="Authorize this claim?">Authorize</x-primary-button>
                    </div>
                @endif
            @endcan

            @can('disburse_welfare_claim')
                @if ($claim->status === 'chairman_authorized')
                    <div class="border-t pt-4 space-y-3">
                        <div>
                            <x-input-label for="paymentReference" value="Payment Reference (optional)" />
                            <x-text-input id="paymentReference" wire:model="paymentReference" type="text" class="mt-1 block w-full" />
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button wire:click="disburse" wire:confirm="Mark this claim as disbursed?">Mark Disbursed</x-primary-button>
                        </div>
                    </div>
                @endif
            @endcan
        </div>

        <livewire:documents.documents-panel :documentable="$claim" :key="'welfare-claim-docs-'.$claim->id" />
    </div>

    @if ($showDeclineForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Decline Claim</h3>
                <div>
                    <x-input-label for="declineNote" value="Reason" />
                    <textarea id="declineNote" wire:model="declineNote" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm text-sm"></textarea>
                    <x-input-error :messages="$errors->get('declineNote')" class="mt-1" />
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeDeclineForm">Cancel</x-secondary-button>
                    <x-primary-button wire:click="decline" wire:loading.attr="disabled">Decline Claim</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
