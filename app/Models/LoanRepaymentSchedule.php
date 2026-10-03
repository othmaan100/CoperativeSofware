<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanRepaymentSchedule extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PARTIALLY_PAID = 'partially_paid';

    public const STATUS_PAID = 'paid';

    public const STATUS_OVERDUE = 'overdue';

    protected $fillable = [
        'loan_id',
        'installment_no',
        'due_date',
        'amount_due',
        'amount_paid',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(LoanRepaymentTransaction::class, 'schedule_id');
    }

    public function balanceRemaining(): float
    {
        return max(0, (float) $this->amount_due - (float) $this->amount_paid);
    }
}
