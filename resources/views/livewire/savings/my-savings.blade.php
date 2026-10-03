<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Savings</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($member->status !== 'active')
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md px-4 py-3 text-sm">
                Your membership status is <strong>{{ ucfirst($member->status) }}</strong>. Voluntary deposits and withdrawal requests are only available to active members.
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse ($accounts as $account)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-semibold">{{ $account->product->name }}</h3>
                        <span class="text-xs text-gray-500">{{ $account->account_no }}</span>
                    </div>
                    <p class="text-2xl font-bold">₦{{ number_format((float) $account->balance, 2) }}</p>

                    @php $committed = $account->committedWithdrawalsTotal(); @endphp
                    @if ($committed > 0)
                        <p class="text-xs text-orange-600 mt-1">
                            ₦{{ number_format($committed, 2) }} authorized for withdrawal, awaiting disbursement —
                            available: ₦{{ number_format($account->balance - $committed, 2) }}
                        </p>
                    @endif

                    @if ($account->target_amount)
                        <p class="text-xs text-gray-500 mt-1">
                            Target: ₦{{ number_format((float) $account->target_amount, 2) }}
                            @if ($account->target_date) by {{ $account->target_date->format('d M Y') }} @endif
                        </p>
                    @endif

                    @php $locked = $account->lockedVoluntaryDepositTotal(); @endphp
                    @if ($locked > 0)
                        <p class="text-xs text-blue-600 mt-1">
                            ₦{{ number_format($locked, 2) }} from a recent voluntary deposit is within its {{ $voluntaryDepositLockMonths }}-month hold
                            @if ($account->nextVoluntaryDepositMaturityDate())
                                — available from {{ $account->nextVoluntaryDepositMaturityDate()->format('d M Y') }}
                            @endif
                        </p>
                    @endif

                    <div class="flex gap-3 mt-4 text-sm">
                        <a href="{{ route('savings.statement', $account) }}" wire:navigate class="text-emerald-600 hover:underline">Statement</a>
                        @if ($member->status === 'active')
                            <button wire:click="openDepositModal({{ $account->id }})" class="text-emerald-600 hover:underline">Log Deposit</button>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No savings accounts yet.</p>
            @endforelse
        </div>

        @if ($withdrawalRequests->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-3">My Withdrawal Requests</h3>
                <div class="space-y-2 text-sm">
                    @foreach ($withdrawalRequests as $req)
                        @php
                            $stageLabel = match ($req->status) {
                                'pending' => 'Awaiting Treasurer review',
                                'treasurer_approved' => 'Endorsed — awaiting Chairman authorization',
                                'chairman_authorized' => 'Authorized — awaiting disbursement',
                                'treasurer_rejected' => 'Rejected by Treasurer',
                                'chairman_declined' => 'Declined by Chairman',
                                default => ucwords(str_replace('_', ' ', $req->status)),
                            };
                            $stageColor = match ($req->status) {
                                'treasurer_rejected', 'chairman_declined' => 'text-red-600',
                                'chairman_authorized' => 'text-orange-600',
                                default => 'text-gray-600',
                            };
                        @endphp
                        <div class="flex justify-between items-center border-b last:border-0 pb-2">
                            <span>
                                {{ $req->account->product->name }} — ₦{{ number_format((float) ($req->approved_amount ?? $req->requested_amount), 2) }}
                                @if ($req->isComplete())
                                    <span class="text-xs text-red-600 font-medium">(Complete Withdrawal)</span>
                                @endif
                            </span>
                            <span class="{{ $stageColor }}">{{ $stageLabel }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($member->status === 'active')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <h3 class="font-semibold">Need to withdraw?</h3>
                        <p class="text-sm text-gray-500">Requests are reviewed by the Treasurer and authorized by the Chairman before disbursement.</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('savings.withdraw') }}" wire:navigate>
                            <x-secondary-button>Request Withdrawal</x-secondary-button>
                        </a>
                        <a href="{{ route('savings.complete-withdraw') }}" wire:navigate>
                            <x-danger-button>Request Complete Withdrawal</x-danger-button>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if ($showDepositModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="font-semibold text-lg mb-4">Log Voluntary Deposit</h3>
                <div class="bg-blue-50 border border-blue-200 text-blue-800 rounded-md px-4 py-3 text-sm mb-4">
                    <strong>Please note:</strong> once confirmed, a voluntary deposit must remain in your account for
                    at least {{ $voluntaryDepositLockMonths }} months before it can be withdrawn. Your compulsory
                    monthly contributions are not affected by this rule.
                </div>
                <div class="space-y-4">
                    <div>
                        <x-input-label for="deposit_amount" value="Amount (₦)" />
                        <x-text-input id="deposit_amount" wire:model="deposit_amount" type="number" step="0.01" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('deposit_amount')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="deposit_note" value="Note (optional)" />
                        <textarea id="deposit_note" wire:model="deposit_note" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    <div>
                        <x-input-label for="deposit_receipt" value="Receipt (optional)" />
                        <input id="deposit_receipt" wire:model="deposit_receipt" type="file" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 block w-full text-sm" />
                        <p class="text-xs text-gray-500 mt-1">Attach a photo or PDF of your teller/deposit slip, if you have one. JPG, PNG or PDF, max 5MB.</p>
                        <x-input-error :messages="$errors->get('deposit_receipt')" class="mt-1" />
                    </div>
                    <p class="text-xs text-gray-500">This logs your intent to deposit. The Treasurer will confirm once payment is received, which posts it to your balance.</p>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <x-secondary-button wire:click="closeDepositModal">Cancel</x-secondary-button>
                    <x-primary-button wire:click="submitDeposit" wire:loading.attr="disabled">Submit</x-primary-button>
                </div>
            </div>
        </div>
    @endif
</div>
