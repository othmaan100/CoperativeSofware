<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">My Application</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if (! $member)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                No application found on this account.
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-start justify-between flex-wrap gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Application No.</p>
                        <p class="text-lg font-semibold">{{ $member->application_no }}</p>
                    </div>

                    @if ($member->membership_no)
                        <div>
                            <p class="text-sm text-gray-500">Membership No.</p>
                            <p class="text-lg font-semibold">{{ $member->membership_no }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <x-member-status-badge :status="$member->status" :rejected="(bool) $member->rejected_at" />
                    </div>
                </div>

                @if ($member->status === 'pending' && $member->rejected_at)
                    <div class="mt-4 bg-red-50 border border-red-200 text-red-800 rounded-md px-4 py-3 text-sm">
                        <strong>Application rejected:</strong> {{ $member->rejection_reason }}
                    </div>
                @elseif ($member->status === 'pending')
                    @if ($member->application_fee_paid)
                        <div class="mt-4 bg-green-50 border border-green-200 text-green-800 rounded-md px-4 py-3 text-sm">
                            Application fee paid{{ $member->application_fee_paid_at ? ' on '.$member->application_fee_paid_at->format('d M Y') : '' }}.
                        </div>
                    @else
                        <div class="mt-4 bg-red-50 border border-red-200 text-red-800 rounded-md px-4 py-3 text-sm flex flex-wrap items-center justify-between gap-3">
                            <span>Your application fee (₦{{ number_format(\App\Models\ApplicationFeePayment::currentFee(), 2) }}) has not been paid yet. Your application cannot be approved until this is settled.</span>
                            <a href="{{ route('my-application.pay-fee') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-600 shrink-0">
                                Pay Now
                            </a>
                        </div>
                    @endif

                    <div class="mt-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md px-4 py-3 text-sm">
                        Your application is under review by the Treasurer. You will be notified once a decision is made.
                    </div>
                @elseif ($member->status === 'active')
                    <div class="mt-4 bg-green-50 border border-green-200 text-green-800 rounded-md px-4 py-3 text-sm">
                        Your application was approved on {{ $member->approved_at?->format('d M Y') }}.
                        Approved monthly contribution: ₦{{ number_format((float) $member->approved_monthly_contribution, 2) }}.
                        <a href="{{ route('my-profile') }}" wire:navigate class="underline font-medium">View my profile &rarr;</a>
                    </div>
                @endif

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 text-sm">
                    <div><dt class="text-gray-500">Full Name</dt><dd class="font-medium">{{ $member->full_name }}</dd></div>
                    <div><dt class="text-gray-500">Department</dt><dd class="font-medium">{{ $member->department }}</dd></div>
                    <div><dt class="text-gray-500">Staff ID</dt><dd class="font-medium">{{ $member->staff_id }}</dd></div>
                    <div><dt class="text-gray-500">Preferred Contribution</dt><dd class="font-medium">₦{{ number_format((float) $member->preferred_monthly_contribution, 2) }}</dd></div>
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold mb-4">Status Timeline</h3>
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
        @endif
    </div>
</div>
