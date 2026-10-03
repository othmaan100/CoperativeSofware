<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Illuminate\Console\Command;

class ProcessOverdueLoans extends Command
{
    protected $signature = 'loans:process-overdue';

    protected $description = 'Flag overdue loan installments, escalate long-overdue loans to defaulted, and call any guarantor pledges whose grace period has elapsed.';

    public function handle(): int
    {
        $loans = Loan::with('product')->whereIn('status', ['active', 'overdue', 'defaulted'])->get();

        $overdueCount = 0;
        $defaultedCount = 0;
        $guarantorCalls = 0;

        foreach ($loans as $loan) {
            $statusBefore = $loan->status;

            $loan->refreshOverdueStatus();
            $loan->refresh();

            if ($loan->status === 'overdue' && $statusBefore !== 'overdue') {
                $overdueCount++;
            }
            if ($loan->status === 'defaulted' && $statusBefore !== 'defaulted') {
                $defaultedCount++;
            }

            $calledBefore = $loan->guarantors()->whereNotNull('called_at')->count();
            $loan->callGuarantorsIfDue();
            $calledAfter = $loan->guarantors()->whereNotNull('called_at')->count();
            $guarantorCalls += ($calledAfter - $calledBefore);
        }

        $this->info("Swept {$loans->count()} loan(s): {$overdueCount} newly overdue, {$defaultedCount} newly defaulted, {$guarantorCalls} guarantor pledge(s) called.");

        return self::SUCCESS;
    }
}
