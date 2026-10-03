<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Application Fee Payment</h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-md px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 rounded-md px-4 py-3 text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @if ($member->application_fee_paid)
                <div class="text-center py-6">
                    <p class="text-emerald-700 font-semibold text-lg">Your application fee has already been paid.</p>
                    <p class="text-sm text-gray-500 mt-1">Paid{{ $member->application_fee_paid_at ? ' on '.$member->application_fee_paid_at->format('d M Y') : '' }}.</p>
                    <a href="{{ route('my-application') }}" wire:navigate class="inline-flex items-center mt-4 px-4 py-2 bg-emerald-700 text-white text-sm font-semibold rounded-md hover:bg-emerald-600">
                        View My Application
                    </a>
                </div>
            @else
                <h3 class="font-semibold text-lg mb-2">Membership Application Fee</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Your application ({{ $member->application_no }}) has been received. Before the Treasurer can review
                    and approve it, please complete payment of the one-time application fee below via Paystack —
                    card, bank transfer, or USSD.
                </p>

                <div class="flex items-center justify-between border-y border-gray-100 dark:border-gray-700 py-4 mb-6">
                    <span class="text-gray-600 dark:text-gray-300">Application Fee</span>
                    <span class="text-2xl font-bold">₦{{ number_format((float) $feeAmount, 2) }}</span>
                </div>

                <x-primary-button wire:click="payNow" wire:loading.attr="disabled" class="w-full justify-center py-3">
                    <span wire:loading.remove wire:target="payNow">Pay with Paystack</span>
                    <span wire:loading wire:target="payNow">Redirecting to Paystack&hellip;</span>
                </x-primary-button>

                <p class="text-xs text-gray-400 mt-3 text-center">You will be redirected to Paystack's secure payment page and brought back here afterward.</p>
            @endif
        </div>

        @if ($member->applicationFeePayments->isNotEmpty())
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-3">Payment Attempts</h3>
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase text-gray-500">
                        <tr><th class="text-left py-1">Reference</th><th class="text-right py-1">Amount</th><th class="text-left py-1">Status</th><th class="text-left py-1">Date</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($member->applicationFeePayments as $payment)
                            <tr class="border-b last:border-0">
                                <td class="py-1 font-mono text-xs">{{ $payment->reference }}</td>
                                <td class="py-1 text-right">₦{{ number_format((float) $payment->amount, 2) }}</td>
                                <td class="py-1">
                                    @if ($payment->status === 'success')
                                        <span class="text-green-700">Successful</span>
                                    @elseif ($payment->status === 'failed')
                                        <span class="text-red-700">Failed</span>
                                    @else
                                        <span class="text-yellow-700">Pending</span>
                                    @endif
                                </td>
                                <td class="py-1 text-gray-500">{{ $payment->initiated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
