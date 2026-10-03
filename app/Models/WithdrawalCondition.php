<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WithdrawalCondition extends Model
{
    protected $fillable = [
        'savings_product_id',
        'rule_type',
        'value',
        'description',
        'created_by',
        'last_edited_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(SavingsProduct::class, 'savings_product_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lastEditedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_edited_by');
    }

    public function label(): string
    {
        return match ($this->rule_type) {
            'minimum_balance' => "Minimum balance: ₦".number_format((float) $this->value, 2),
            'minimum_membership_duration' => "Minimum membership: {$this->value} month(s) before first withdrawal",
            'max_withdrawal_pct_of_balance' => "Max withdrawal: {$this->value}% of balance per request",
            'cooling_period' => "Cooling-off: {$this->value} day(s) between withdrawals",
            default => $this->rule_type,
        };
    }

    /**
     * Evaluate all active rules for a product against a proposed withdrawal.
     * $excludingRequestId lets a request being re-evaluated (e.g. by the
     * Chairman, after the Treasurer already committed it) ignore its own
     * already-committed amount rather than double-counting it.
     * Returns a list of ['rule_type' => ..., 'passed' => bool, 'message' => ...].
     */
    public static function evaluate(SavingsAccount $account, float $amount, ?int $excludingRequestId = null): array
    {
        $results = [];

        $rules = self::query()
            ->where('savings_product_id', $account->savings_product_id)
            ->where('is_active', true)
            ->get();

        foreach ($rules as $rule) {
            $results[] = match ($rule->rule_type) {
                'minimum_balance' => self::checkMinimumBalance($account, $amount, $rule, $excludingRequestId),
                'minimum_membership_duration' => self::checkMembershipDuration($account, $rule),
                'max_withdrawal_pct_of_balance' => self::checkMaxPct($account, $amount, $rule),
                'cooling_period' => self::checkCoolingPeriod($account, $rule),
                default => ['rule_type' => $rule->rule_type, 'passed' => true, 'message' => null],
            };
        }

        return $results;
    }

    protected static function checkMinimumBalance(SavingsAccount $account, float $amount, self $rule, ?int $excludingRequestId = null): array
    {
        $minimum = (float) $rule->value;
        $available = $account->availableBalance($excludingRequestId);
        $remaining = $available - $amount;
        $passed = $remaining >= $minimum;

        return [
            'rule_type' => 'minimum_balance',
            'passed' => $passed,
            'message' => $passed ? null : "This withdrawal would leave ₦".number_format($remaining, 2)." — below the required minimum of ₦".number_format($minimum, 2).' (after accounting for any other authorized withdrawals still awaiting disbursement).',
        ];
    }

    protected static function checkMembershipDuration(SavingsAccount $account, self $rule): array
    {
        $months = (int) $rule->value;
        $approvedAt = $account->member->approved_at;
        $eligible = $approvedAt && $approvedAt->diffInMonths(now()) >= $months;

        return [
            'rule_type' => 'minimum_membership_duration',
            'passed' => (bool) $eligible,
            'message' => $eligible ? null : "Member must be active for at least {$months} month(s) before withdrawing.",
        ];
    }

    protected static function checkMaxPct(SavingsAccount $account, float $amount, self $rule): array
    {
        $pct = (float) $rule->value;
        $max = (float) $account->balance * ($pct / 100);
        $passed = $amount <= $max;

        return [
            'rule_type' => 'max_withdrawal_pct_of_balance',
            'passed' => $passed,
            'message' => $passed ? null : "Maximum withdrawal per request is {$pct}% of balance (₦".number_format($max, 2).").",
        ];
    }

    protected static function checkCoolingPeriod(SavingsAccount $account, self $rule): array
    {
        $days = (int) $rule->value;

        $lastDisbursed = WithdrawalRequest::query()
            ->where('savings_account_id', $account->id)
            ->where('status', 'disbursed')
            ->latest('disbursed_at')
            ->first();

        $eligible = ! $lastDisbursed || $lastDisbursed->disbursed_at->diffInDays(now()) >= $days;

        return [
            'rule_type' => 'cooling_period',
            'passed' => (bool) $eligible,
            'message' => $eligible ? null : "Must wait {$days} day(s) between withdrawals from this account.",
        ];
    }
}
