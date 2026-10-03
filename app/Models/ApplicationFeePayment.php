<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationFeePayment extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_SUCCESS = 'success';

    public const STATUS_FAILED = 'failed';

    public const SOURCE_PAYSTACK = 'paystack';

    public const SOURCE_MANUAL = 'manual';

    public const SOURCE_LEGACY_IMPORT = 'legacy_import';

    protected $fillable = [
        'member_id',
        'reference',
        'amount',
        'status',
        'channel',
        'source',
        'admin_pct',
        'profit_pct',
        'admin_amount',
        'profit_amount',
        'recorded_by',
        'paystack_response',
        'initiated_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'admin_pct' => 'decimal:2',
        'profit_pct' => 'decimal:2',
        'admin_amount' => 'decimal:2',
        'profit_amount' => 'decimal:2',
        'paystack_response' => 'array',
        'initiated_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    /**
     * The admin-charge/profit split currently configured — Chairman-editable,
     * same concept as the loan module's interest split. Every payment
     * snapshots these values at the moment it's confirmed, so a later change
     * never rewrites the amounts already reported for past registrations.
     */
    public static function currentSplit(): array
    {
        return [
            'admin_pct' => (float) Setting::get('application_fee_admin_pct', 20),
            'profit_pct' => (float) Setting::get('application_fee_profit_pct', 80),
        ];
    }

    protected static function splitAmounts(float $amount): array
    {
        $split = self::currentSplit();
        $adminAmount = round($amount * $split['admin_pct'] / 100, 2);
        $profitAmount = round($amount - $adminAmount, 2);

        return [
            'admin_pct' => $split['admin_pct'],
            'profit_pct' => $split['profit_pct'],
            'admin_amount' => $adminAmount,
            'profit_amount' => $profitAmount,
        ];
    }

    /**
     * Apply a Paystack verification response to this payment and, if it
     * confirms success, mark the member's application fee as paid. Safe to
     * call more than once for the same reference (from both the browser
     * callback and the webhook) — a payment already recorded as successful
     * is never re-applied.
     */
    public function applyVerification(array $data): void
    {
        if ($this->isSuccessful()) {
            return;
        }

        $paidNow = ($data['status'] ?? null) === 'success'
            && strtoupper((string) ($data['currency'] ?? 'NGN')) === 'NGN'
            && (float) ($data['amount'] ?? 0) / 100 >= (float) $this->amount;

        $this->update(array_merge([
            'status' => $paidNow ? self::STATUS_SUCCESS : self::STATUS_FAILED,
            'channel' => $data['channel'] ?? null,
            'paystack_response' => $data,
            'paid_at' => $paidNow ? now() : null,
        ], $paidNow ? array_merge(['source' => self::SOURCE_PAYSTACK], self::splitAmounts((float) $this->amount)) : []));

        if (! $paidNow) {
            return;
        }

        $member = $this->member;

        if ($member->application_fee_paid) {
            return;
        }

        $member->update([
            'application_fee_paid' => true,
            'application_fee_paid_at' => now(),
            'application_fee_source' => 'paystack',
            'application_fee_marked_by' => null,
        ]);

        $member->logEvent('application_fee_paid', [
            'source' => 'paystack',
            'reference' => $this->reference,
            'amount' => (float) $this->amount,
        ]);

        ActivityLog::record(
            action: 'member.application_fee_paid',
            description: "Application fee paid via Paystack for {$member->full_name} ({$member->application_no}).",
            subject: $member,
            properties: ['reference' => $this->reference, 'amount' => (float) $this->amount],
        );
    }

    /**
     * Record a Treasurer's manual override (bank transfer/cash) as a
     * completed payment, so it flows through the same revenue ledger and
     * reporting as Paystack payments — never a silent, untracked flag flip.
     */
    public static function recordManual(Member $member, float $amount, int $recordedBy, ?string $note = null): self
    {
        return self::create(array_merge([
            'member_id' => $member->id,
            'reference' => 'MANUAL-'.str_replace('/', '-', $member->application_no).'-'.now()->format('YmdHis'),
            'amount' => $amount,
            'status' => self::STATUS_SUCCESS,
            'source' => self::SOURCE_MANUAL,
            'recorded_by' => $recordedBy,
            'paystack_response' => $note ? ['note' => $note] : null,
            'initiated_at' => now(),
            'paid_at' => now(),
        ], self::splitAmounts($amount)));
    }

    /**
     * Record a legacy member-import row's already-settled fee, so historical
     * revenue is reflected in the same ledger even though the exact original
     * payment method/date is not preserved from the paper record.
     */
    public static function recordLegacyImport(Member $member, float $amount, int $recordedBy): self
    {
        return self::create(array_merge([
            'member_id' => $member->id,
            'reference' => 'LEGACY-'.str_replace('/', '-', $member->application_no).'-'.now()->format('YmdHis'),
            'amount' => $amount,
            'status' => self::STATUS_SUCCESS,
            'source' => self::SOURCE_LEGACY_IMPORT,
            'recorded_by' => $recordedBy,
            'initiated_at' => now(),
            'paid_at' => now(),
        ], self::splitAmounts($amount)));
    }
}
