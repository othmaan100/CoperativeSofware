<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanRepaymentBatch extends Model
{
    protected $fillable = [
        'period',
        'uploaded_by',
        'file_path',
        'total_amount',
        'total_records',
        'status',
        'rows',
        'validation_errors',
        'posted_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'rows' => 'array',
        'validation_errors' => 'array',
        'posted_at' => 'datetime',
    ];

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(LoanRepaymentTransaction::class, 'source_batch_id');
    }

    public function matchedRows(): array
    {
        return collect($this->rows ?? [])->where('matched', true)->all();
    }

    public function flaggedRows(): array
    {
        return collect($this->rows ?? [])->where('matched', false)->all();
    }
}
