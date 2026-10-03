<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    public const STATUS_OPEN = 'open';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_RESOLVED = 'resolved';

    public const CATEGORIES = [
        'loan' => 'Loan',
        'savings' => 'Savings',
        'share_capital' => 'Share Capital',
        'dividend' => 'Dividend',
        'staff_conduct' => 'Staff Conduct',
        'general' => 'General',
    ];

    /**
     * Purely informational — shown to whoever raises a ticket as a hint.
     * Any staff member with handle_complaints can still pick up any
     * category; this is not an access-control routing table.
     */
    public const TYPICAL_HANDLERS = [
        'loan' => 'Treasurer',
        'savings' => 'Treasurer',
        'share_capital' => 'Treasurer',
        'dividend' => 'Treasurer',
        'staff_conduct' => 'Chairman',
        'general' => 'Secretary',
    ];

    protected $fillable = [
        'ticket_no',
        'member_id',
        'raised_by',
        'category',
        'subject',
        'is_confidential',
        'status',
        'assigned_to',
        'resolved_by',
        'resolved_at',
    ];

    protected $casts = [
        'is_confidential' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function raisedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'raised_by');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class)->orderBy('created_at');
    }

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    public function typicalHandlerLabel(): string
    {
        return self::TYPICAL_HANDLERS[$this->category] ?? 'Any staff';
    }

    /**
     * Single source of truth for "can this user see this ticket" — the
     * member it concerns and whoever raised it always can; beyond that it
     * depends on the confidential flag and the handling permissions.
     */
    public function userCanView(Authenticatable $user): bool
    {
        if ($this->member->user_id === $user->id || $this->raised_by === $user->id) {
            return true;
        }

        return $this->is_confidential
            ? $user->can('handle_confidential_complaints')
            : $user->can('handle_complaints');
    }

    public static function generateTicketNo(): string
    {
        return DB::transaction(function () {
            $last = static::query()->lockForUpdate()->orderByDesc('id')->value('ticket_no');

            $next = 1;
            if ($last && preg_match('/(\d+)$/', $last, $matches)) {
                $next = ((int) $matches[1]) + 1;
            }

            return sprintf('TCK/%05d', $next);
        });
    }
}
