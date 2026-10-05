<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Fields that are locked after approval and can only be changed
     * directly by a Super Admin (never via a member change request).
     */
    public const LOCKED_FIELDS = [
        'department',
        'staff_id',
        'rank_grade',
        'staff_category',
        'status',
    ];

    public const STAFF_CATEGORIES = [
        'senior_staff' => 'Senior Staff',
        'junior_staff' => 'Junior Staff',
    ];

    /**
     * Personal/contact fields a member must have on file. A bulk legacy
     * import may leave these blank; a member with any missing is prompted
     * to fill them in on their next login (see EnsureProfileIsComplete).
     * Administratively-locked fields (department, rank_grade, etc.) are
     * deliberately excluded — those are filled in by a Super Admin.
     */
    public const PROFILE_COMPLETION_FIELDS = [
        'phone_1', 'email', 'gender', 'date_of_birth', 'marital_status', 'home_address',
    ];

    protected $fillable = [
        'user_id',
        'application_no',
        'membership_no',
        'membership_date',
        'full_name',
        'date_of_birth',
        'gender',
        'ippis_number',
        'marital_status',
        'home_address',
        'phone_1',
        'phone_2',
        'email',
        'photo_path',
        'department',
        'staff_id',
        'date_of_first_appointment',
        'employment_status',
        'rank_grade',
        'staff_category',
        'preferred_monthly_contribution',
        'approved_monthly_contribution',
        'mode_of_deduction',
        'member_category',
        'declaration_accepted',
        'declaration_signed_name',
        'status',
        'application_fee_paid',
        'application_fee_paid_at',
        'application_fee_source',
        'application_fee_marked_by',
        'applied_at',
        'approved_by',
        'approved_at',
        'rejected_at',
        'rejection_reason',
        'dormant_flagged_at',
        'last_contribution_at',
        'exit_requested_by',
        'exit_requested_at',
        'exit_treasurer_cleared',
        'exit_cleared_by',
        'exit_cleared_at',
        'exited_at',
        'exit_reason',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_of_first_appointment' => 'date',
        'membership_date' => 'date',
        'preferred_monthly_contribution' => 'decimal:2',
        'approved_monthly_contribution' => 'decimal:2',
        'declaration_accepted' => 'boolean',
        'application_fee_paid' => 'boolean',
        'application_fee_paid_at' => 'datetime',
        'applied_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'dormant_flagged_at' => 'datetime',
        'last_contribution_at' => 'datetime',
        'exit_requested_at' => 'datetime',
        'exit_treasurer_cleared' => 'boolean',
        'exit_cleared_at' => 'datetime',
        'exited_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function applicationFeeMarkedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'application_fee_marked_by');
    }

    public function applicationFeePayments(): HasMany
    {
        return $this->hasMany(ApplicationFeePayment::class)->latest('initiated_at');
    }

    public function exitRequestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'exit_requested_by');
    }

    public function exitClearedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'exit_cleared_by');
    }

    public function nextOfKin(): HasMany
    {
        return $this->hasMany(NextOfKin::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(MemberStatusHistory::class)->latest('created_at');
    }

    public function changeRequests(): HasMany
    {
        return $this->hasMany(MemberChangeRequest::class)->latest('requested_at');
    }

    public function events(): HasMany
    {
        return $this->hasMany(MemberEvent::class)->latest('created_at');
    }

    public function savingsAccounts(): HasMany
    {
        return $this->hasMany(SavingsAccount::class);
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function welfareClaims(): HasMany
    {
        return $this->hasMany(WelfareClaim::class);
    }

    public function contributionChangeRequests(): HasMany
    {
        return $this->hasMany(ContributionChangeRequest::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function repaymentReversals(): HasMany
    {
        return $this->hasMany(LoanRepaymentReversal::class);
    }

    public function guaranteedLoans(): HasMany
    {
        return $this->hasMany(LoanGuarantor::class, 'guarantor_member_id');
    }

    public function commodityRequests(): HasMany
    {
        return $this->hasMany(CommodityRequest::class);
    }

    /**
     * A member may not start a new commodity request while a previous
     * commodity loan is still outstanding — it must be fully cleared first.
     */
    public function hasActiveCommodityLoan(): bool
    {
        return $this->loans()
            ->whereHas('product', fn ($q) => $q->where('code', LoanProduct::COMMODITY))
            ->whereIn('status', Loan::ACTIVE_STATUSES)
            ->exists();
    }

    public function regularSavingsAccount(): ?SavingsAccount
    {
        return $this->savingsAccounts()
            ->whereHas('product', fn ($q) => $q->where('code', SavingsProduct::REGULAR))
            ->first();
    }

    public function shareAccount(): HasOne
    {
        return $this->hasOne(ShareAccount::class);
    }

    public function dividendAllocations(): HasMany
    {
        return $this->hasMany(DividendAllocation::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable')->latest();
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class)->latest();
    }

    public function shareWithdrawalRequests(): HasMany
    {
        return $this->hasMany(ShareWithdrawalRequest::class);
    }

    public static function isFieldLocked(string $field): bool
    {
        return in_array($field, self::LOCKED_FIELDS, true);
    }

    /**
     * Which of the core personal/next-of-kin fields are still blank.
     * Keys matching PROFILE_COMPLETION_FIELDS, plus nok_name/nok_relationship/nok_phone.
     */
    public function missingProfileFields(): array
    {
        $missing = [];

        foreach (self::PROFILE_COMPLETION_FIELDS as $field) {
            if (blank($this->{$field})) {
                $missing[] = $field;
            }
        }

        // A record with no next-of-kin row at all predates this feature or is
        // a test fixture, not a legacy import gap (importRow() always creates
        // one) — only flag blanks on a row that actually exists.
        $nok = $this->nextOfKin()->first();

        if ($nok) {
            foreach (['nok_name' => 'name', 'nok_relationship' => 'relationship', 'nok_phone' => 'phone'] as $key => $column) {
                if (blank($nok->{$column})) {
                    $missing[] = $key;
                }
            }
        }

        return $missing;
    }

    public function hasCompleteProfile(): bool
    {
        return empty($this->missingProfileFields());
    }

    /**
     * Sequential application number, e.g. FCET/CSL/00001.
     */
    public static function generateApplicationNo(): string
    {
        return DB::transaction(function () {
            $last = static::withTrashed()->lockForUpdate()->orderByDesc('id')->value('application_no');

            $next = 1;
            if ($last && preg_match('/(\d+)$/', $last, $matches)) {
                $next = ((int) $matches[1]) + 1;
            }

            return sprintf('FCET/CSL/%05d', $next);
        });
    }

    /**
     * Membership number derived from the staff ID, per society policy.
     */
    public function generateMembershipNo(): string
    {
        return sprintf('FCET/CSL/%s', $this->staff_id);
    }

    public function staffCategoryLabel(): string
    {
        return self::STAFF_CATEGORIES[$this->staff_category] ?? '—';
    }

    /**
     * Record a status transition and update the member's current status.
     */
    public function transitionTo(string $toStatus, ?int $changedBy, ?string $reason = null): void
    {
        $from = $this->status;

        $this->status = $toStatus;
        $this->save();

        $this->statusHistory()->create([
            'from_status' => $from,
            'to_status' => $toStatus,
            'changed_by' => $changedBy,
            'reason' => $reason,
        ]);
    }

    public function logEvent(string $type, array $payload = [], ?int $causedBy = null): void
    {
        $this->events()->create([
            'event_type' => $type,
            'payload' => $payload,
            'caused_by' => $causedBy,
        ]);
    }

    // --- Exit clearance checklist ---

    public function hasOutstandingLoans(): bool
    {
        return $this->loans()->whereIn('status', Loan::ACTIVE_STATUSES)->exists();
    }

    public function hasActiveGuarantorObligations(): bool
    {
        return $this->guaranteedLoans()
            ->where('status', LoanGuarantor::STATUS_ACCEPTED)
            ->whereNull('called_at')
            ->whereHas('loan', fn ($q) => $q->whereIn('status', Loan::ACTIVE_STATUSES))
            ->exists();
    }

    public function savingsSharesBalance(): float
    {
        return (float) $this->savingsAccounts()->sum('balance') + (float) ($this->shareAccount?->balance ?? 0);
    }

    public function isClearForExit(): bool
    {
        return ! $this->hasOutstandingLoans() && ! $this->hasActiveGuarantorObligations();
    }

    // --- Query scopes ---

    public function scopePendingQueue($query)
    {
        return $query->where('status', 'pending')->whereNull('rejected_at');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'pending')->whereNotNull('rejected_at');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    public function scopeDormant($query)
    {
        return $query->where('status', 'dormant');
    }

    public function scopeExited($query)
    {
        return $query->where('status', 'exited');
    }

    public function scopeDeceased($query)
    {
        return $query->where('status', 'deceased');
    }
}
