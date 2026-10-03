<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $member->full_name }}</h2>
            <x-member-status-badge :status="$member->status" :rejected="(bool) $member->rejected_at" />
        </div>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        {{-- Summary --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex flex-wrap gap-6 items-start">
                @if ($member->photo_path)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($member->photo_path) }}" class="h-24 w-24 object-cover rounded-lg" alt="Photo">
                @endif
                <dl class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm flex-1">
                    <div><dt class="text-gray-500">Application No.</dt><dd class="font-medium">{{ $member->application_no }}</dd></div>
                    <div><dt class="text-gray-500">Membership No.</dt><dd class="font-medium">{{ $member->membership_no ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Date Joined</dt><dd class="font-medium">{{ $member->membership_date?->format('d M Y') ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Staff ID</dt><dd class="font-medium">{{ $member->staff_id }}</dd></div>
                    <div><dt class="text-gray-500">Department</dt><dd class="font-medium">{{ $member->department }}</dd></div>
                    <div><dt class="text-gray-500">Rank / Grade</dt><dd class="font-medium">{{ $member->rank_grade ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Staff Category</dt><dd class="font-medium">{{ $member->staffCategoryLabel() }}</dd></div>
                    <div><dt class="text-gray-500">Employment Status</dt><dd class="font-medium">{{ ucfirst($member->employment_status) }}</dd></div>
                    <div><dt class="text-gray-500">Phone</dt><dd class="font-medium">{{ $member->phone_1 }}</dd></div>
                    <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $member->email ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Preferred Contribution</dt><dd class="font-medium">₦{{ number_format((float) $member->preferred_monthly_contribution, 2) }}</dd></div>
                    <div><dt class="text-gray-500">Approved Contribution</dt><dd class="font-medium">₦{{ number_format((float) $member->approved_monthly_contribution, 2) }}</dd></div>
                    <div><dt class="text-gray-500">Application Fee</dt><dd class="font-medium">{{ $member->application_fee_paid ? 'Paid on '.$member->application_fee_paid_at?->format('d M Y').' ('.str_replace('_', ' ', $member->application_fee_source ?? 'unknown').')' : 'Unpaid' }}</dd></div>
                    @if ($member->nextOfKin->first())
                        <div><dt class="text-gray-500">Next of Kin</dt><dd class="font-medium">{{ $member->nextOfKin->first()->name }} ({{ $member->nextOfKin->first()->relationship }})</dd></div>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Financial Summary --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Financial Summary</h3>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm mb-6">
                <div>
                    <p class="text-gray-500">Total Savings</p>
                    <p class="font-semibold text-lg">₦{{ number_format((float) $member->savingsAccounts->sum('balance'), 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Share Capital</p>
                    <p class="font-semibold text-lg">₦{{ number_format((float) ($member->shareAccount?->balance ?? 0), 2) }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($member->shareAccount?->total_shares ?? 0) }} shares</p>
                </div>
                <div>
                    <p class="text-gray-500">Active Loans</p>
                    <p class="font-semibold text-lg">{{ $member->loans->count() }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Total Outstanding</p>
                    <p class="font-semibold text-lg">₦{{ number_format((float) $member->loans->sum('outstanding_balance'), 2) }}</p>
                </div>
            </div>

            @if ($member->savingsAccounts->isNotEmpty())
                <div class="mb-6">
                    <h4 class="text-xs uppercase text-gray-500 mb-2">Savings Accounts</h4>
                    <table class="w-full text-sm">
                        <thead class="text-xs uppercase text-gray-500">
                            <tr><th class="text-left py-1">Account</th><th class="text-left py-1">Product</th><th class="text-right py-1">Balance</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($member->savingsAccounts as $account)
                                <tr class="border-b last:border-0">
                                    <td class="py-1">{{ $account->account_no }}</td>
                                    <td class="py-1">{{ $account->product->name }}</td>
                                    <td class="py-1 text-right">₦{{ number_format((float) $account->balance, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($member->loans->isNotEmpty())
                <div>
                    <h4 class="text-xs uppercase text-gray-500 mb-2">Active Loans</h4>
                    <table class="w-full text-sm">
                        <thead class="text-xs uppercase text-gray-500">
                            <tr>
                                <th class="text-left py-1">Product</th>
                                <th class="text-right py-1">Principal</th>
                                <th class="text-right py-1">Total Repayable</th>
                                <th class="text-right py-1">Total Paid</th>
                                <th class="text-right py-1">Outstanding</th>
                                <th class="text-right py-1">Monthly Installment</th>
                                <th class="text-left py-1">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member->loans as $loan)
                                <tr class="border-b last:border-0">
                                    <td class="py-1">{{ $loan->product->name }}</td>
                                    <td class="py-1 text-right">₦{{ number_format((float) $loan->principal_amount, 2) }}</td>
                                    <td class="py-1 text-right">₦{{ number_format((float) $loan->total_repayable, 2) }}</td>
                                    <td class="py-1 text-right">₦{{ number_format($loan->totalPaid(), 2) }}</td>
                                    <td class="py-1 text-right">₦{{ number_format((float) $loan->outstanding_balance, 2) }}</td>
                                    <td class="py-1 text-right">₦{{ number_format((float) $loan->monthly_installment, 2) }}</td>
                                    <td class="py-1">{{ ucfirst($loan->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-500">No active loans.</p>
            @endif
        </div>

        <livewire:documents.documents-panel :documentable="$member" :key="'member-docs-'.$member->id" />

        {{-- Locked fields (Super Admin only) --}}
        @can('editLockedFields', $member)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">Locked Fields</h3>
                    @unless ($editingLocked)
                        <button wire:click="$set('editingLocked', true)" class="text-sm text-emerald-600 hover:underline">Edit</button>
                    @endunless
                </div>

                @if ($editingLocked)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="department" value="Department" />
                            <x-text-input id="department" wire:model="department" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('department')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="staff_id" value="Staff ID" />
                            <x-text-input id="staff_id" wire:model="staff_id" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('staff_id')" class="mt-1" />
                        </div>
                        <div>
                            <x-input-label for="rank_grade" value="Rank / Grade" />
                            <x-text-input id="rank_grade" wire:model="rank_grade" type="text" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="staff_category" value="Staff Category" />
                            <select id="staff_category" wire:model="staff_category" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="">— Not set —</option>
                                <option value="senior_staff">Senior Staff</option>
                                <option value="junior_staff">Junior Staff</option>
                            </select>
                            <x-input-error :messages="$errors->get('staff_category')" class="mt-1" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <x-secondary-button wire:click="$set('editingLocked', false)">Cancel</x-secondary-button>
                        <x-primary-button wire:click="saveLockedFields">Save</x-primary-button>
                    </div>
                @else
                    <p class="text-sm text-gray-500">Department, Staff ID, Rank/Grade and Staff Category can only be edited here by a Super Admin.</p>
                @endif
            </div>
        @endcan

        {{-- Status actions --}}
        @can('manageStatus', $member)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-4">Status Actions</h3>
                <div class="flex flex-wrap gap-2">
                    @if ($member->status === 'active')
                        <x-secondary-button wire:click="confirmAction('suspend')">Suspend</x-secondary-button>
                        @if ($member->dormant_flagged_at)
                            <x-secondary-button wire:click="confirmDormant" wire:confirm="Confirm this member as dormant?">Confirm Dormant</x-secondary-button>
                        @endif
                    @elseif ($member->status === 'suspended')
                        <x-primary-button wire:click="reactivateFromSuspended" wire:confirm="Reactivate this member?">Reactivate</x-primary-button>
                    @elseif ($member->status === 'dormant')
                        <x-primary-button wire:click="reactivateFromDormant" wire:confirm="Reactivate this member?">Reactivate</x-primary-button>
                    @endif

                    @if (in_array($member->status, ['active', 'suspended', 'dormant']))
                        <x-danger-button wire:click="confirmAction('deceased')">Mark Deceased</x-danger-button>
                    @endif
                </div>

                @if ($pendingAction)
                    <div class="mt-4 border-t pt-4">
                        <x-input-label for="action_reason" value="Reason" />
                        <textarea id="action_reason" wire:model="action_reason" rows="2" class="mt-1 block w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('action_reason')" class="mt-1" />
                        <div class="flex justify-end gap-2 mt-3">
                            <x-secondary-button wire:click="cancelAction">Cancel</x-secondary-button>
                            @if ($pendingAction === 'suspend')
                                <x-danger-button wire:click="suspend">Confirm Suspend</x-danger-button>
                            @elseif ($pendingAction === 'deceased')
                                <x-danger-button wire:click="markDeceased">Confirm Deceased</x-danger-button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endcan

        {{-- Exit / withdrawal clearance --}}
        @if ($member->exit_requested_at)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-4">Exit / Withdrawal Clearance</h3>
                <p class="text-sm text-gray-500 mb-3">Requested {{ $member->exit_requested_at->format('d M Y') }} — {{ $member->exit_reason }}</p>

                <ul class="text-sm space-y-1 mb-4">
                    <li>Outstanding loans: {{ $member->hasOutstandingLoans() ? 'Yes — blocked' : 'None' }}</li>
                    <li>Active guarantor obligations: {{ $member->hasActiveGuarantorObligations() ? 'Yes — blocked' : 'None' }}</li>
                    <li>Savings/Shares balance for disposition: ₦{{ number_format($member->savingsSharesBalance(), 2) }}</li>
                </ul>

                @if ($member->exited_at)
                    <p class="text-sm text-green-700">Exit finalized on {{ $member->exited_at->format('d M Y') }}.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @can('manageStatus', $member)
                            @if (! $member->exit_treasurer_cleared)
                                <x-secondary-button wire:click="treasurerSignOff" wire:confirm="Sign off exit clearance as Treasurer?">Treasurer Sign-Off</x-secondary-button>
                            @else
                                <span class="text-sm text-green-700 self-center">Cleared by {{ $member->exitClearedBy?->name }} on {{ $member->exit_cleared_at?->format('d M Y') }}</span>
                            @endif
                        @endcan

                        @can('editLockedFields', $member)
                            @if ($member->exit_treasurer_cleared)
                                <x-danger-button wire:click="finalizeExit" wire:confirm="Finalize exit? This cannot be undone.">Finalize Exit</x-danger-button>
                            @endif
                        @endcan
                    </div>
                @endif
            </div>
        @endif

        {{-- Deceased — next of kin disbursement --}}
        @if ($member->status === 'deceased')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-4">Next-of-Kin Disbursement</h3>

                @if ($member->withdrawalRequests->isEmpty())
                    <p class="text-sm text-gray-500 mb-3">No disbursement has been initiated yet.</p>
                    <p class="text-sm mb-3">Savings/Shares balance available: <strong>₦{{ number_format($member->savingsSharesBalance(), 2) }}</strong></p>

                    @can('treasurer_review_withdrawal')
                        <a href="{{ route('treasurer.deceased-disbursement', $member) }}" wire:navigate>
                            <x-primary-button>Initiate Disbursement to Next of Kin</x-primary-button>
                        </a>
                    @endcan
                @else
                    @foreach ($member->withdrawalRequests as $wr)
                        @php
                            $stageLabel = match ($wr->status) {
                                'treasurer_approved' => 'Awaiting Chairman authorization',
                                'chairman_authorized' => 'Authorized — awaiting disbursement',
                                'chairman_declined' => 'Declined by Chairman',
                                'disbursed' => 'Disbursed on '.$wr->disbursed_at?->format('d M Y'),
                                default => ucwords(str_replace('_', ' ', $wr->status)),
                            };
                        @endphp
                        <div class="text-sm border-b last:border-0 py-2">
                            <div class="flex justify-between">
                                <span>To {{ $wr->account_name }} ({{ $wr->bank_name }}) — ₦{{ number_format((float) ($wr->approved_amount ?? $wr->requested_amount), 2) }}</span>
                                <span class="text-gray-500">{{ $stageLabel }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif

        {{-- Deceased — welfare death benefit claim --}}
        @if ($member->status === 'deceased')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-4">Welfare Death Benefit Claim</h3>

                @if ($member->welfareClaims->isEmpty())
                    <p class="text-sm text-gray-500 mb-3">No welfare claim has been raised yet.</p>

                    @can('initiate_welfare_claim')
                        <a href="{{ route('welfare.claims.create', $member) }}" wire:navigate>
                            <x-primary-button>File Welfare Claim</x-primary-button>
                        </a>
                    @endcan
                @else
                    @foreach ($member->welfareClaims as $claim)
                        <div class="text-sm border-b last:border-0 py-2">
                            <div class="flex justify-between">
                                <a href="{{ route('welfare.claims.show', $claim) }}" wire:navigate class="text-emerald-700 hover:underline">{{ $claim->claim_no }} — ₦{{ number_format((float) $claim->amount, 2) }}</a>
                                <span class="text-gray-500">{{ ucwords(str_replace('_', ' ', $claim->status)) }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif

        {{-- Change request history --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Change Request History</h3>
            @forelse ($member->changeRequests as $cr)
                <div class="text-sm border-b last:border-0 py-2 flex justify-between">
                    <span>{{ $cr->fieldLabel() }}: {{ $cr->old_value }} &rarr; {{ $cr->new_value }}</span>
                    <span class="text-gray-500">{{ ucfirst($cr->status) }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">No change requests yet.</p>
            @endforelse
        </div>

        {{-- Status history / audit trail --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="font-semibold mb-4">Status History</h3>
            <ol class="relative border-s border-gray-200 dark:border-gray-700 ms-2">
                @forelse ($member->statusHistory as $history)
                    <li class="mb-6 ms-4">
                        <div class="absolute w-2 h-2 bg-gray-400 rounded-full mt-1.5 -start-1"></div>
                        <time class="text-xs text-gray-400">{{ $history->created_at->format('d M Y, H:i') }}</time>
                        <p class="text-sm">
                            <span class="font-medium">{{ ucfirst($history->to_status) }}</span>
                            @if ($history->changedBy)
                                <span class="text-gray-500">by {{ $history->changedBy->name }}</span>
                            @endif
                        </p>
                        @if ($history->reason)
                            <p class="text-xs text-gray-500">{{ $history->reason }}</p>
                        @endif
                    </li>
                @empty
                    <p class="text-sm text-gray-500">No history yet.</p>
                @endforelse
            </ol>
        </div>
    </div>
</div>
