<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'causer_id',
        'causer_name',
        'causer_email',
        'subject_type',
        'subject_id',
        'action',
        'description',
        'properties',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * The single write path for the system-wide activity log. Every
     * state-changing action across every module should call this — never
     * write to activity_logs directly. Safe to call with no authenticated
     * user (e.g. a failed login attempt) and no subject (e.g. a setting
     * change with no single owning record).
     */
    public static function record(
        string $action,
        string $description,
        ?Model $subject = null,
        array $properties = [],
        ?int $causerId = null,
    ): self {
        $causer = $causerId ? User::find($causerId) : Auth::user();

        return self::create([
            'causer_id' => $causer?->id,
            'causer_name' => $causer?->name,
            'causer_email' => $causer?->email,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'action' => $action,
            'description' => $description,
            'properties' => $properties ?: null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'created_at' => now(),
        ]);
    }
}
