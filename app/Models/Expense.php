<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_CHAIRMAN_AUTHORIZED = 'chairman_authorized';

    public const STATUS_CHAIRMAN_DECLINED = 'chairman_declined';

    public const STATUS_PAID = 'paid';

    protected $fillable = [
        'expense_no',
        'budget_line_id',
        'description',
        'amount',
        'status',
        'initiated_by',
        'chairman_reviewed_by',
        'chairman_reviewed_at',
        'chairman_note',
        'paid_by',
        'paid_at',
        'payment_reference',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'chairman_reviewed_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function budgetLine(): BelongsTo
    {
        return $this->belongsTo(BudgetLine::class);
    }

    public function initiatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function chairmanReviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chairman_reviewed_by');
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public static function generateExpenseNo(): string
    {
        return DB::transaction(function () {
            $last = static::query()->lockForUpdate()->orderByDesc('id')->value('expense_no');

            $next = 1;
            if ($last && preg_match('/(\d+)$/', $last, $matches)) {
                $next = ((int) $matches[1]) + 1;
            }

            return sprintf('EXP/%05d', $next);
        });
    }
}
