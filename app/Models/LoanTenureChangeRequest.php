<?php

namespace App\Models;

use App\Notifications\LoanTenureChangedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class LoanTenureChangeRequest extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_DECLINED = 'declined';

    protected $fillable = [
        'loan_id',
        'member_id',
        'current_tenure_months',
        'requested_tenure_months',
        'current_installment',
        'proposed_installment',
        'applied_installment',
        'reason',
        'status',
        'requested_by',
        'requested_at',
        'chairman_reviewed_by',
        'chairman_reviewed_at',
        'chairman_note',
    ];

    protected $casts = [
        'current_installment' => 'decimal:2',
        'proposed_installment' => 'decimal:2',
        'applied_installment' => 'decimal:2',
        'requested_at' => 'datetime',
        'chairman_reviewed_at' => 'datetime',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function chairmanReviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chairman_reviewed_by');
    }

    /**
     * Apply the new tenure to the loan (re-spreading what is still owed) and
     * mark the request approved, in one transaction. The installment is
     * recomputed from the loan as it stands now, since repayments may have
     * posted since the Treasurer raised the request.
     */
    public function approve(int $chairmanId, ?string $note = null): void
    {
        DB::transaction(function () use ($chairmanId, $note) {
            /** @var self $request */
            $request = self::query()->lockForUpdate()->findOrFail($this->id);

            if ($request->status !== self::STATUS_PENDING) {
                throw new RuntimeException('This request has already been reviewed.');
            }

            $loan = Loan::query()->lockForUpdate()->findOrFail($request->loan_id);
            $newInstallment = $loan->extendTenure((int) $request->requested_tenure_months);

            $request->update([
                'status' => self::STATUS_APPROVED,
                'applied_installment' => $newInstallment,
                'chairman_reviewed_by' => $chairmanId,
                'chairman_reviewed_at' => now(),
                'chairman_note' => $note ?: null,
            ]);

            $this->setRawAttributes($request->getAttributes(), true);
        });

        $this->loan->member->user?->notify(new LoanTenureChangedNotification($this->fresh(['loan'])));
    }
}
