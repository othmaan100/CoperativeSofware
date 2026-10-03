<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanGuarantor extends Model
{
    public const STATUS_INVITED = 'invited';

    public const STATUS_ACCEPTED = 'accepted';

    public const STATUS_DECLINED = 'declined';

    protected $fillable = [
        'loan_id',
        'guarantor_member_id',
        'pledged_amount',
        'status',
        'accepted_at',
        'declined_at',
        'called_at',
        'deduction_transaction_id',
    ];

    protected $casts = [
        'pledged_amount' => 'decimal:2',
        'accepted_at' => 'datetime',
        'declined_at' => 'datetime',
        'called_at' => 'datetime',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function guarantorMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'guarantor_member_id');
    }

    public function deductionTransaction(): BelongsTo
    {
        return $this->belongsTo(SavingsTransaction::class, 'deduction_transaction_id');
    }

    public function isAccepted(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }
}
