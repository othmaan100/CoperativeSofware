<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanRepaymentIntent extends Model
{
    protected $fillable = [
        'loan_id',
        'member_id',
        'amount',
        'note',
        'receipt_path',
        'receipt_original_filename',
        'status',
        'confirmed_by',
        'confirmed_at',
        'decline_reason',
        'transaction_id',
        'requested_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
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

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(LoanRepaymentTransaction::class, 'transaction_id');
    }
}
