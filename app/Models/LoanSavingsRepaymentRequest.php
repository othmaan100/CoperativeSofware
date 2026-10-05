<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanSavingsRepaymentRequest extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_DECLINED = 'declined';

    protected $fillable = [
        'loan_id',
        'member_id',
        'savings_account_id',
        'amount',
        'status',
        'reviewed_by',
        'reviewed_at',
        'decline_reason',
        'savings_transaction_id',
        'loan_repayment_transaction_id',
        'requested_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
        'requested_at' => 'datetime',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function savingsAccount(): BelongsTo
    {
        return $this->belongsTo(SavingsAccount::class);
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function savingsTransaction(): BelongsTo
    {
        return $this->belongsTo(SavingsTransaction::class);
    }

    public function loanRepaymentTransaction(): BelongsTo
    {
        return $this->belongsTo(LoanRepaymentTransaction::class);
    }

    /**
     * The member's savings position right now, for this request: the raw
     * balance, what can actually be used (balance minus other pending
     * commitments and still-locked voluntary deposits), the loan's
     * outstanding balance, and the most this request could be approved for.
     */
    public function savingsPosition(): object
    {
        $account = $this->savingsAccount;
        $usable = $account->withdrawableBalance(null, $this->id);
        $outstanding = (float) $this->loan->outstanding_balance;

        return (object) [
            'balance' => (float) $account->balance,
            'usable' => $usable,
            'outstanding' => $outstanding,
            'max_approvable' => min($usable, $outstanding),
        ];
    }

    public function exceedsAvailableSavings(): bool
    {
        return (float) $this->amount > $this->savingsPosition()->max_approvable + 0.001;
    }
}
