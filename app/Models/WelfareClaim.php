<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class WelfareClaim extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_CHAIRMAN_AUTHORIZED = 'chairman_authorized';

    public const STATUS_CHAIRMAN_DECLINED = 'chairman_declined';

    public const STATUS_DISBURSED = 'disbursed';

    protected $fillable = [
        'claim_no',
        'member_id',
        'date_of_death',
        'beneficiary_name',
        'beneficiary_relationship',
        'beneficiary_phone',
        'bank_name',
        'account_number',
        'account_name',
        'amount',
        'status',
        'initiated_by',
        'chairman_reviewed_by',
        'chairman_reviewed_at',
        'chairman_note',
        'disbursed_by',
        'disbursed_at',
        'payment_reference',
    ];

    protected $casts = [
        'date_of_death' => 'date',
        'amount' => 'decimal:2',
        'chairman_reviewed_at' => 'datetime',
        'disbursed_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function initiatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function chairmanReviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chairman_reviewed_by');
    }

    public function disbursedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disbursed_by');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable')->latest();
    }

    public static function generateClaimNo(): string
    {
        return DB::transaction(function () {
            $last = static::query()->lockForUpdate()->orderByDesc('id')->value('claim_no');

            $next = 1;
            if ($last && preg_match('/(\d+)$/', $last, $matches)) {
                $next = ((int) $matches[1]) + 1;
            }

            return sprintf('WLF/%05d', $next);
        });
    }
}
