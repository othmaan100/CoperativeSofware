<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Welfare Claims</h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <p class="text-sm text-gray-500">A welfare claim is raised from a deceased member's profile page.</p>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-4 py-3">Claim No.</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Date of Death</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($claims as $claim)
                        <tr wire:key="claim-{{ $claim->id }}">
                            <td class="px-4 py-3 font-medium">{{ $claim->claim_no }}</td>
                            <td class="px-4 py-3">{{ $claim->member->full_name }}</td>
                            <td class="px-4 py-3">{{ $claim->date_of_death->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">₦{{ number_format((float) $claim->amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ match($claim->status) {
                                    'disbursed' => 'bg-green-100 text-green-800',
                                    'chairman_authorized' => 'bg-blue-100 text-blue-800',
                                    'chairman_declined' => 'bg-red-100 text-red-800',
                                    default => 'bg-yellow-100 text-yellow-800',
                                } }}">
                                    {{ ucwords(str_replace('_', ' ', $claim->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('welfare.claims.show', $claim) }}" wire:navigate class="text-emerald-700 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No welfare claims yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $claims->links() }}
    </div>
</div>
