<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanRepaymentReversal extends Model
{
    public const STATUS_AWAITING_CHOICE = 'awaiting_choice';

    public const STATUS_AWAITING_PROCESSING = 'awaiting_processing';

    public const STATUS_COMPLETED = 'completed';

    public const RESOLUTION_APPLY_TO_LOAN = 'apply_to_loan';

    public const RESOLUTION_REFUND = 'refund';

    protected $fillable = [
        'member_id',
        'loan_id',
        'repayment_transaction_id',
        'reversal_transaction_id',
        'amount',
        'status',
        'resolution',
        'target_loan_id',
        'applied_transaction_id',
        'bank_name',
        'account_number',
        'account_name',
        'refund_reference',
        'chosen_at',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'chosen_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function targetLoan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'target_loan_id');
    }

    public function repaymentTransaction(): BelongsTo
    {
        return $this->belongsTo(LoanRepaymentTransaction::class, 'repayment_transaction_id');
    }

    public function reversalTransaction(): BelongsTo
    {
        return $this->belongsTo(LoanRepaymentTransaction::class, 'reversal_transaction_id');
    }

    public function appliedTransaction(): BelongsTo
    {
        return $this->belongsTo(LoanRepaymentTransaction::class, 'applied_transaction_id');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_AWAITING_CHOICE => 'Awaiting your choice',
            self::STATUS_AWAITING_PROCESSING => $this->resolution === self::RESOLUTION_REFUND
                ? 'Refund requested — awaiting Treasurer'
                : 'Transfer requested — awaiting Treasurer',
            self::STATUS_COMPLETED => 'Reversal completed',
            default => ucwords(str_replace('_', ' ', $this->status)),
        };
    }

    public function resolutionLabel(): string
    {
        return match ($this->resolution) {
            self::RESOLUTION_APPLY_TO_LOAN => 'Apply to loan '.($this->targetLoan?->loan_no ?? ''),
            self::RESOLUTION_REFUND => 'Refund to bank account',
            default => '—',
        };
    }
}
