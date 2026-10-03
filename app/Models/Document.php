<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'title',
        'file_path',
        'original_filename',
        'mime_type',
        'file_size',
        'uploaded_by',
    ];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Deletes the underlying private-disk file along with the row — the two
     * must never drift apart, so this is the only way a Document should be
     * removed.
     */
    public function deleteWithFile(): void
    {
        Storage::disk('local')->delete($this->file_path);
        $this->delete();
    }

    /**
     * Single source of truth for "can this user see documents on this
     * record" — shared by the DocumentsPanel component and the download
     * controller so the two never drift apart. Only Member, Loan and
     * WelfareClaim are supported documentable types today.
     */
    public static function userCanView(Authenticatable $user, Model $documentable): bool
    {
        if ($documentable instanceof Member) {
            return $user->can('view_all_members') || $documentable->user_id === $user->id;
        }

        if ($documentable instanceof \App\Models\Loan) {
            return $user->can('treasurer_review_loan')
                || $user->can('chairman_authorize_loan')
                || $documentable->member->user_id === $user->id;
        }

        if ($documentable instanceof \App\Models\WelfareClaim) {
            return $user->can('initiate_welfare_claim')
                || $user->can('authorize_welfare_claim')
                || $user->can('disburse_welfare_claim')
                || $user->can('view_welfare_reports');
        }

        return false;
    }

    public static function userCanManage(Authenticatable $user, Model $documentable): bool
    {
        if ($documentable instanceof Member) {
            return $user->can('manage_member_documents') || $documentable->user_id === $user->id;
        }

        if ($documentable instanceof \App\Models\Loan) {
            return $user->can('manage_loan_documents') || $documentable->member->user_id === $user->id;
        }

        if ($documentable instanceof \App\Models\WelfareClaim) {
            return $user->can('initiate_welfare_claim') || $user->can('authorize_welfare_claim');
        }

        return false;
    }

    public function humanFileSize(): string
    {
        $bytes = $this->file_size;

        if ($bytes < 1024) {
            return "{$bytes} B";
        }

        if ($bytes < 1024 * 1024) {
            return round($bytes / 1024, 1).' KB';
        }

        return round($bytes / (1024 * 1024), 1).' MB';
    }
}
