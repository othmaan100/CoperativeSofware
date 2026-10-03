<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        /* DejaVu Sans (bundled with dompdf) is required here — the default PDF
           base fonts (Helvetica/Arial substitutes) have no glyph for ₦ and
           silently render it as "?". */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; }
        h1 { font-size: 16px; margin-bottom: 0; }
        h2 { font-size: 13px; color: #555; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border-bottom: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; text-transform: uppercase; font-size: 9px; }
        .text-right { text-align: right; }
        .credit { color: #15803d; }
        .debit { color: #b91c1c; }
        .meta { margin-top: 10px; }
        .meta td { border: none; padding: 2px 8px 2px 0; }
    </style>
</head>
<body>
    <h1>FCE (T) Potiskum Staff Cooperative Society Limited</h1>
    <h2>Savings Statement</h2>

    <table class="meta">
        <tr><td><strong>Member:</strong></td><td>{{ $account->member->full_name }} ({{ $account->member->membership_no }})</td></tr>
        <tr><td><strong>Account:</strong></td><td>{{ $account->account_no }} — {{ $account->product->name }}</td></tr>
        <tr><td><strong>Period:</strong></td><td>{{ \Carbon\Carbon::parse($from)->format('d M Y') }} to {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</td></tr>
        <tr><td><strong>Current Balance:</strong></td><td>₦{{ number_format((float) $account->balance, 2) }}</td></tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Description</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Balance After</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $txn)
                <tr>
                    <td>{{ $txn->posted_at->format('d M Y') }}</td>
                    <td>
                        {{ ucwords(str_replace('_', ' ', $txn->type)) }}
                        @if ($txn->isReversed()) (reversed) @endif
                    </td>
                    <td>{{ $txn->description }}</td>
                    <td class="text-right {{ $txn->isCredit() ? 'credit' : 'debit' }}">
                        {{ $txn->isCredit() ? '+' : '-' }}₦{{ number_format((float) $txn->amount, 2) }}
                    </td>
                    <td class="text-right">₦{{ number_format((float) $txn->balance_after, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No transactions in this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
