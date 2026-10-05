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

    /** Released with nothing in stock — closed without a loan. */
    public const STATUS_NOT_SUPPLIED = 'not_supplied';

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
     * Value requested, from the priced lines — kept even after release
     * overwrites commodity_subtotal with the value actually released.
     */
    public function requestedSubtotal(): float
    {
        return round((float) $this->lines->sum('line_total'), 2);
    }

    /**
     * Release goods to the member. $releasedQuantities maps each line id to
     * the good-condition quantity actually handed over; $shortfallReasons
     * says why any line got less than requested (not in stock / damaged).
     * A line can never take more than the Store Officer's verified good
     * stock still left for that item. Only what was released is charged:
     * the request's totals and the Commodity Loan are rebuilt from the
     * released lines, with the cycle's markup applied to that value. If
     * nothing at all was released, no loan is created and the request is
     * closed as not supplied (returns null).
     *
     * This is the per-member trigger — the cycle-wide approval chain only
     * unlocks it, it does not itself start anyone's repayment clock.
     */
    public function releaseGoods(int $releasedBy, array $releasedQuantities, array $shortfallReasons = []): ?Loan
    {
        return DB::transaction(function () use ($releasedBy, $releasedQuantities, $shortfallReasons) {
            $cycle = $this->cycle;

            foreach ($this->lines as $line) {
                $quantity = round((float) ($releasedQuantities[$line->id] ?? 0), 2);
                $requested = (float) $line->quantity;

                if ($quantity < 0 || $quantity > $requested) {
                    throw new \InvalidArgumentException("Released quantity for {$line->label()} must be between 0 and {$requested}.");
                }

                $stock = CommodityCyclePrice::query()
                    ->where('commodity_cycle_id', $cycle->id)
                    ->where('commodity_item_id', $line->commodity_item_id)
                    ->lockForUpdate()
                    ->first();
                $available = $stock?->quantityAvailable($line->id);

                if ($available !== null && $quantity > $available) {
                    throw new \InvalidArgumentException("Only {$available} of {$line->label()} left in good condition.");
                }

                $reason = null;
                if ($quantity < $requested) {
                    $reason = ($shortfallReasons[$line->id] ?? null) === CommodityRequestLine::SHORTFALL_DAMAGED
                        ? CommodityRequestLine::SHORTFALL_DAMAGED
                        : CommodityRequestLine::SHORTFALL_NOT_IN_STOCK;
                }

                // Units found damaged at release were counted as good stock;
                // move them across so the remaining good stock stays accurate.
                if ($reason === CommodityRequestLine::SHORTFALL_DAMAGED && $available !== null) {
                    $damagedUnits = min($requested - $quantity, $available - $quantity);
                    if ($damagedUnits > 0) {
                        $stock->update([
                            'quantity_in_store' => round((float) $stock->quantity_in_store - $damagedUnits, 2),
                            'quantity_damaged' => round((float) $stock->quantity_damaged + $damagedUnits, 2),
                        ]);
                    }
                }

                $line->update([
                    'quantity_released' => $quantity,
                    'released_line_total' => round($quantity * (float) $line->fixed_unit_price, 2),
                    'shortfall_reason' => $reason,
                ]);
            }

            $subtotal = round((float) $this->lines()->sum('released_line_total'), 2);

            if ($subtotal <= 0) {
                $this->update([
                    'commodity_subtotal' => 0,
                    'markup_amount' => 0,
                    'total_repayable' => 0,
                    'monthly_installment' => 0,
                    'status' => self::STATUS_NOT_SUPPLIED,
                    'released_by' => $releasedBy,
                    'released_at' => now(),
                ]);

                return null;
            }

            $markup = round($subtotal * $cycle->markupPctTotal() / 100, 2);
            $total = round($subtotal + $markup, 2);

            $this->update([
                'commodity_subtotal' => $subtotal,
                'markup_amount' => $markup,
                'total_repayable' => $total,
                'monthly_installment' => round($total / max(1, (int) $cycle->tenure_months), 2),
            ]);

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
