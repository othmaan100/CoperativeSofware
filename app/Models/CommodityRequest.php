<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class CommodityRequest extends Model
{
    public const STATUS_SUBMITTED = 'submitted';

    public const STATUS_PRICED = 'priced';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'commodity_cycle_id',
        'member_id',
        'loan_id',
        'commodity_subtotal',
        'markup_amount',
        'total_repayable',
        'monthly_installment',
        'salary_deduction_authorized',
        'status',
        'released_by',
        'released_at',
    ];

    protected $casts = [
        'commodity_subtotal' => 'decimal:2',
        'markup_amount' => 'decimal:2',
        'total_repayable' => 'decimal:2',
        'monthly_installment' => 'decimal:2',
        'salary_deduction_authorized' => 'boolean',
        'released_at' => 'datetime',
    ];

    public function cycle(): BelongsTo
    {
        return $this->belongsTo(CommodityCycle::class, 'commodity_cycle_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(CommodityRequestLine::class);
    }

    public function releasedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'released_by');
    }

    public function isEditable(): bool
    {
        return $this->status === self::STATUS_SUBMITTED && $this->cycle->isRequestWindowOpen();
    }

    /**
     * Release goods to the member: creates the actual Loan record (product =
     * Commodity), generates its repayment schedule anchored past the
     * cycle's moratorium from today, and marks this request active. This is
     * the per-member trigger — the cycle-wide approval chain only unlocks
     * it, it does not itself start anyone's repayment clock.
     */
    public function releaseGoods(int $releasedBy): Loan
    {
        return DB::transaction(function () use ($releasedBy) {
            $cycle = $this->cycle;
            $product = LoanProduct::query()->where('code', LoanProduct::COMMODITY)->firstOrFail();

            $adminAmount = round((float) $this->commodity_subtotal * (float) $cycle->markup_admin_pct / 100, 2);
            $profitAmount = round((float) $this->markup_amount - $adminAmount, 2);

            $loan = Loan::create([
                'member_id' => $this->member_id,
                'loan_product_id' => $product->id,
                'loan_no' => Loan::generateLoanNo(),
                'principal_amount' => $this->commodity_subtotal,
                'interest_admin_pct' => $cycle->markup_admin_pct,
                'interest_profit_pct' => $cycle->markup_profit_pct,
                'total_interest' => $this->markup_amount,
                'interest_admin_amount' => $adminAmount,
                'interest_profit_amount' => $profitAmount,
                'total_repayable' => $this->total_repayable,
                'tenure_months' => $cycle->tenure_months,
                'monthly_installment' => $this->monthly_installment,
                'multiplier_applied' => null,
                'outstanding_balance' => $this->total_repayable,
                'status' => 'active',
                'applied_at' => $this->created_at,
                'disbursed_by' => $releasedBy,
                'disbursed_at' => now(),
                'disbursement_method' => 'goods',
                'disbursement_reference' => "COMMODITY-CYCLE-{$cycle->id}",
            ]);

            $loan->generateSchedule(now()->copy()->addMonthsNoOverflow($cycle->moratorium_months));

            $this->update([
                'loan_id' => $loan->id,
                'status' => self::STATUS_ACTIVE,
                'released_by' => $releasedBy,
                'released_at' => now(),
            ]);

            return $loan;
        });
    }
}
