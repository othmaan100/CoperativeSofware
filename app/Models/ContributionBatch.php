<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContributionBatch extends Model
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
        return $this->hasMany(SavingsTransaction::class, 'source_batch_id');
    }

    public function matchedRows(): array
    {
        return collect($this->rows ?? [])->where('matched', true)->all();
    }

    public function flaggedRows(): array
    {
        return collect($this->rows ?? [])->where('matched', false)->all();
    }

    /**
     * The date a period's contributions are recorded on: the last day of that
     * month, when salary deductions are made. A month that hasn't ended yet
     * is recorded now, so nothing is ever dated in the future.
     */
    public static function contributionDate(string $period): Carbon
    {
        $date = Carbon::createFromFormat('!Y-m', $period)->endOfMonth()->startOfDay();

        return $date->isFuture() ? now() : $date;
    }
}
