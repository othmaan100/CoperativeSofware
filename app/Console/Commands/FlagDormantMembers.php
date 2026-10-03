<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Console\Command;

class FlagDormantMembers extends Command
{
    protected $signature = 'members:flag-dormant';

    protected $description = 'Flag active members with no contribution activity for the configured dormancy period, for Super Admin confirmation.';

    public function handle(): int
    {
        $months = (int) Setting::get('dormancy_months', 6);
        $cutoff = now()->subMonths($months);

        $candidates = Member::active()
            ->whereNull('dormant_flagged_at')
            ->where(function ($query) use ($cutoff) {
                $query->where(function ($q) use ($cutoff) {
                    $q->whereNotNull('last_contribution_at')->where('last_contribution_at', '<=', $cutoff);
                })->orWhere(function ($q) use ($cutoff) {
                    $q->whereNull('last_contribution_at')->where('approved_at', '<=', $cutoff);
                });
            })
            ->get();

        foreach ($candidates as $member) {
            $member->update(['dormant_flagged_at' => now()]);
            $member->logEvent('dormancy_flagged', ['inactivity_months' => $months]);
            ActivityLog::record(
                action: 'member.dormancy_flagged',
                description: "Flagged {$member->full_name} ({$member->membership_no}) as a dormancy candidate after {$months} months of inactivity.",
                subject: $member,
                properties: ['inactivity_months' => $months],
            );
        }

        $this->info("Flagged {$candidates->count()} member(s) as dormancy candidates.");

        return self::SUCCESS;
    }
}
