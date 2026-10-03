<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class DividendPeriod extends Model
{
    public const STATUS_OPEN = 'open';

    public const STATUS_DECLARED = 'declared';

    public const STATUS_CALCULATED = 'calculated';

    public const STATUS_POSTED = 'posted';

    protected $fillable = [
        'label',
        'fy_start_date',
        'fy_end_date',
        'status',
        'share_dividend_rate_pct',
        'savings_interest_rate_pct',
        'distributable_profit_snapshot',
        'total_share_dividend_amount',
        'total_savings_interest_amount',
        'opened_by',
        'declared_by',
        'declared_at',
        'calculated_by',
        'calculated_at',
        'posted_by',
        'posted_at',
    ];

    protected $casts = [
        'fy_start_date' => 'date',
        'fy_end_date' => 'date',
        'share_dividend_rate_pct' => 'decimal:2',
        'savings_interest_rate_pct' => 'decimal:2',
        'distributable_profit_snapshot' => 'decimal:2',
        'total_share_dividend_amount' => 'decimal:2',
        'total_savings_interest_amount' => 'decimal:2',
        'declared_at' => 'datetime',
        'calculated_at' => 'datetime',
        'posted_at' => 'datetime',
    ];

    public function allocations(): HasMany
    {
        return $this->hasMany(DividendAllocation::class);
    }

    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function declaredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'declared_by');
    }

    public function calculatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'calculated_by');
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Loan interest profit (commodity loans included — they are posted as
     * ordinary Loan rows) booked within the range, plus registration fee
     * profit booked within the range. This is a booked-at-recognition
     * figure, not cash actually collected — an advisory reference only,
     * never a hard cap on what the Board can declare.
     */
    public static function distributableProfitFor(\DateTimeInterface $start, \DateTimeInterface $end): float
    {
        $loanProfit = (float) Loan::query()
            ->whereBetween('disbursed_at', [$start, $end])
            ->sum('interest_profit_amount');

        $registrationProfit = (float) ApplicationFeePayment::query()
            ->where('status', ApplicationFeePayment::STATUS_SUCCESS)
            ->whereBetween('paid_at', [$start, $end])
            ->sum('profit_amount');

        return round($loanProfit + $registrationProfit, 2);
    }

    /**
     * (Re)computes every active member's time-weighted average Share
     * Capital and Savings balances over this period, and the resulting
     * dividend/interest amounts at the declared rates. Safe to re-run any
     * number of times while the period is not yet posted — each run
     * replaces the previous "calculated" allocations.
     */
    public function calculate(int $calculatedBy): void
    {
        abort_unless(in_array($this->status, [self::STATUS_DECLARED, self::STATUS_CALCULATED], true), 400, 'Rates must be declared before calculating.');

        $shareRate = (float) $this->share_dividend_rate_pct;
        $savingsRate = (float) $this->savings_interest_rate_pct;
        $start = $this->fy_start_date->copy()->startOfDay();
        $end = $this->fy_end_date->copy()->endOfDay();

        DB::transaction(function () use ($shareRate, $savingsRate, $start, $end, $calculatedBy) {
            $this->allocations()->where('status', self::STATUS_CALCULATED)->delete();

            $totalShareDividend = 0.0;
            $totalSavingsInterest = 0.0;

            Member::query()
                ->where('status', 'active')
                ->with(['shareAccount', 'savingsAccounts'])
                ->chunkById(100, function ($members) use ($shareRate, $savingsRate, $start, $end, &$totalShareDividend, &$totalSavingsInterest) {
                    foreach ($members as $member) {
                        $avgShare = $member->shareAccount?->averageBalanceBetween($start, $end) ?? 0.0;
                        $avgSavings = $member->savingsAccounts->sum(fn ($account) => $account->averageBalanceBetween($start, $end));

                        $shareDividend = round($avgShare * $shareRate / 100, 2);
                        $savingsInterest = round($avgSavings * $savingsRate / 100, 2);

                        if ($shareDividend <= 0 && $savingsInterest <= 0) {
                            continue;
                        }

                        $this->allocations()->create([
                            'member_id' => $member->id,
                            'average_share_balance' => $avgShare,
                            'average_savings_balance' => $avgSavings,
                            'share_rate_applied' => $shareRate,
                            'savings_rate_applied' => $savingsRate,
                            'share_dividend_amount' => $shareDividend,
                            'savings_interest_amount' => $savingsInterest,
                            'status' => self::STATUS_CALCULATED,
                        ]);

                        $totalShareDividend += $shareDividend;
                        $totalSavingsInterest += $savingsInterest;
                    }
                });

            $this->update([
                'status' => self::STATUS_CALCULATED,
                'calculated_by' => $calculatedBy,
                'calculated_at' => now(),
                'total_share_dividend_amount' => round($totalShareDividend, 2),
                'total_savings_interest_amount' => round($totalSavingsInterest, 2),
            ]);
        });
    }

    /**
     * Credits every calculated allocation into the member's Regular Savings
     * account (as two separate, clearly-labelled ledger entries) and locks
     * the period. Irreversible through this method — corrections must go
     * through the standard reversal mechanism on the resulting savings
     * transactions.
     */
    public function post(int $postedBy): void
    {
        abort_unless($this->status === self::STATUS_CALCULATED, 400, 'Only a calculated period can be posted.');

        $regularProduct = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->firstOrFail();

        DB::transaction(function () use ($regularProduct, $postedBy) {
            $this->allocations()
                ->where('status', self::STATUS_CALCULATED)
                ->with('member')
                ->chunkById(100, function ($allocations) use ($regularProduct, $postedBy) {
                    foreach ($allocations as $allocation) {
                        $account = SavingsAccount::openFor($allocation->member, $regularProduct);
                        $dividendTxnId = null;
                        $interestTxnId = null;

                        if ($allocation->share_dividend_amount > 0) {
                            $dividendTxnId = $account->recordTransaction(
                                type: 'dividend_credit',
                                amount: (float) $allocation->share_dividend_amount,
                                description: "Share Capital dividend for {$this->label}",
                                postedBy: $postedBy,
                                reference: "DIVIDEND-{$this->id}",
                            )->id;
                        }

                        if ($allocation->savings_interest_amount > 0) {
                            $interestTxnId = $account->recordTransaction(
                                type: 'interest_credit',
                                amount: (float) $allocation->savings_interest_amount,
                                description: "Savings interest for {$this->label}",
                                postedBy: $postedBy,
                                reference: "DIVIDEND-{$this->id}",
                            )->id;
                        }

                        $allocation->update([
                            'status' => self::STATUS_POSTED,
                            'dividend_transaction_id' => $dividendTxnId,
                            'interest_transaction_id' => $interestTxnId,
                        ]);

                        $allocation->member->user?->notify(new \App\Notifications\DividendPostedNotification(
                            $this->label,
                            (float) $allocation->share_dividend_amount,
                            (float) $allocation->savings_interest_amount,
                        ));
                    }
                });

            $this->update([
                'status' => self::STATUS_POSTED,
                'posted_by' => $postedBy,
                'posted_at' => now(),
            ]);
        });
    }
}
