<?php

namespace App\Console\Commands;

use App\Models\ContributionBatch;
use App\Models\Member;
use App\Models\MemberImportBatch;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * One-off fix for savings records imported before entries could be dated:
 * contributions are moved to the last day of their batch's period, and
 * imported opening balances to the member's join date. Running balances are
 * then rebuilt in date order. Amounts and final balances do not change.
 */
class DateLegacySavingsRecords extends Command
{
    protected $signature = 'savings:date-legacy-records {--apply : Make the changes (without it, only shows what would change)}';

    protected $description = 'Date imported contributions to their period and opening balances to the join date';

    public function handle(): int
    {
        $changes = [];

        $contributions = SavingsTransaction::query()
            ->where('type', 'contribution_deduction')
            ->whereNotNull('source_batch_id')
            ->with('sourceBatch:id,period')
            ->get(['id', 'savings_account_id', 'source_batch_id', 'posted_at']);

        foreach ($contributions as $entry) {
            if (! $entry->sourceBatch) {
                continue;
            }

            $date = ContributionBatch::contributionDate($entry->sourceBatch->period);
            if ($entry->posted_at->gt($date)) {
                $changes[] = [$entry, $date];
            }
        }
        $contributionCount = count($changes);

        $openings = SavingsTransaction::query()
            ->where('type', 'opening_balance')
            ->where('reference', 'like', 'IMPORT-%')
            ->with('account:id,member_id')
            ->get(['id', 'savings_account_id', 'posted_at']);

        $members = Member::query()->whereIn('id', $openings->pluck('account.member_id'))->get()->keyBy('id');

        foreach ($openings as $entry) {
            $member = $members->get($entry->account?->member_id);
            if (! $member) {
                continue;
            }

            $date = MemberImportBatch::openingBalanceDate($member);
            if ($entry->posted_at->gt($date)) {
                $changes[] = [$entry, $date];
            }
        }

        $accountIds = collect($changes)->map(fn ($change) => $change[0]->savings_account_id)->unique();

        $this->info("Contributions to re-date: {$contributionCount}");
        $this->info('Opening balances to re-date: '.(count($changes) - $contributionCount));
        $this->info("Savings accounts affected: {$accountIds->count()}");

        if (! $this->option('apply')) {
            $this->comment('Nothing changed. Run again with --apply to make these changes.');

            return self::SUCCESS;
        }

        $balancesBefore = SavingsAccount::query()->whereIn('id', $accountIds)->pluck('balance', 'id');

        DB::transaction(function () use ($changes, $accountIds) {
            foreach ($changes as [$entry, $date]) {
                SavingsTransaction::query()->whereKey($entry->id)->update(['posted_at' => $date]);
            }

            SavingsAccount::query()->whereIn('id', $accountIds)->get()->each->rebuildRunningBalances();
        });

        $mismatched = SavingsAccount::query()->whereIn('id', $accountIds)->get()
            ->filter(fn ($account) => bccomp((string) $account->balance, (string) $balancesBefore[$account->id], 2) !== 0);

        if ($mismatched->isNotEmpty()) {
            $this->error('Balances changed for account(s): '.$mismatched->pluck('account_no')->implode(', ').'. Check these accounts.');

            return self::FAILURE;
        }

        $this->info('Done. Every account balance is unchanged; only the dates and running balances were updated.');

        return self::SUCCESS;
    }
}
