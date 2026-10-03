<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanRepaymentTransaction extends Model
{
    public const TYPE_SALARY_DEDUCTION = 'salary_deduction';

    public const TYPE_VOLUNTARY_LUMP_SUM = 'voluntary_lump_sum';

    public const TYPE_REVERSAL = 'reversal';

    protected $fillable = [
        'loan_id',
        'schedule_id',
        'type',
        'amount',
        'balance_after',
        'reference',
        'description',
        'source_batch_id',
        'reversed_transaction_id',
        'posted_by',
        'posted_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'posted_at' => 'datetime',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(LoanRepaymentSchedule::class, 'schedule_id');
    }

    public function sourceBatch(): BelongsTo
    {
        return $this->belongsTo(LoanRepaymentBatch::class, 'source_batch_id');
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}
