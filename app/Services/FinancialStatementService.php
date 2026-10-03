<?php

namespace App\Services;

use App\Models\ApplicationFeePayment;
use App\Models\DividendPeriod;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\SavingsAccount;
use App\Models\ShareAccount;
use Illuminate\Support\Carbon;

/**
 * Derives Trial Balance / Income Statement / Balance Sheet directly from the
 * existing, already-immutable module ledgers (savings, loans, shares,
 * registration fees, dividends) rather than a separate double-entry journal
 * — every figure here traces back to a real posted transaction, so there is
 * no second bookkeeping system to keep in sync or that can drift from the
 * modules it summarizes.
 *
 * Key policy choices baked into this class (documented here since there is
 * no accountant in the loop to confirm them):
 *  - Loan interest (including commodity loan markup, which is posted as an
 *    ordinary Loan row) is recognized as income at DISBURSEMENT, not as
 *    repayments are collected — matching the same convention already used
 *    for the Dividends module's advisory profit figure.
 *  - Savings interest paid to members is a genuine expense (cost of funds),
 *    as are the cooperative's own operating expenses (Budgeting module) —
 *    both recognized when actually PAID (cash basis), not when merely
 *    logged or authorized.
 *  - Share dividends are a DISTRIBUTION of already-earned profit, not an
 *    expense — they reduce Retained Earnings directly, the same way a
 *    company's dividend does not appear on its income statement.
 *  - "Cash & Bank" is not tracked anywhere in this system (no bank
 *    integration exists), so it is shown as an IMPLIED balancing figure —
 *    what should be held in the bank given everything else recorded — for
 *    the Treasurer to reconcile against the real bank statement, never a
 *    directly-recorded balance.
 */
class FinancialStatementService
{
    protected function inceptionDate(): Carbon
    {
        return Carbon::create(2000, 1, 1)->startOfDay();
    }

    public function incomeStatement(Carbon $start, Carbon $end): array
    {
        $loanInterestAdmin = round((float) Loan::query()->whereBetween('disbursed_at', [$start, $end])->sum('interest_admin_amount'), 2);
        $loanInterestProfit = round((float) Loan::query()->whereBetween('disbursed_at', [$start, $end])->sum('interest_profit_amount'), 2);

        $feePayments = ApplicationFeePayment::query()->where('status', ApplicationFeePayment::STATUS_SUCCESS)->whereBetween('paid_at', [$start, $end]);
        $regFeeAdmin = round((float) (clone $feePayments)->sum('admin_amount'), 2);
        $regFeeProfit = round((float) (clone $feePayments)->sum('profit_amount'), 2);

        $savingsInterestExpense = round((float) DividendPeriod::query()->where('status', DividendPeriod::STATUS_POSTED)->whereBetween('posted_at', [$start, $end])->sum('total_savings_interest_amount'), 2);
        $operatingExpenses = round((float) Expense::query()->where('status', Expense::STATUS_PAID)->whereBetween('paid_at', [$start, $end])->sum('amount'), 2);

        $income = [
            ['label' => 'Loan Interest Income — Administrative', 'amount' => $loanInterestAdmin],
            ['label' => 'Loan Interest Income — Distributable Profit', 'amount' => $loanInterestProfit],
            ['label' => 'Registration Fee Income — Administrative', 'amount' => $regFeeAdmin],
            ['label' => 'Registration Fee Income — Distributable Profit', 'amount' => $regFeeProfit],
        ];
        $expenses = [
            ['label' => 'Savings Interest Expense', 'amount' => $savingsInterestExpense],
            ['label' => 'Operating Expenses', 'amount' => $operatingExpenses],
        ];

        $totalIncome = round(array_sum(array_column($income, 'amount')), 2);
        $totalExpenses = round(array_sum(array_column($expenses, 'amount')), 2);

        return [
            'period' => ['start' => $start, 'end' => $end],
            'income' => $income,
            'total_income' => $totalIncome,
            'expenses' => $expenses,
            'total_expenses' => $totalExpenses,
            'net_income' => round($totalIncome - $totalExpenses, 2),
        ];
    }

    public function shareDividendsDeclared(Carbon $start, Carbon $end): float
    {
        return round((float) DividendPeriod::query()
            ->where('status', DividendPeriod::STATUS_POSTED)
            ->whereBetween('posted_at', [$start, $end])
            ->sum('total_share_dividend_amount'), 2);
    }

    /**
     * Cumulative net income since inception minus cumulative share
     * dividends declared since inception — the Balance Sheet's Retained
     * Earnings line as of any date.
     */
    public function retainedEarningsAsOf(Carbon $date): float
    {
        $statement = $this->incomeStatement($this->inceptionDate(), $date);
        $dividends = $this->shareDividendsDeclared($this->inceptionDate(), $date);

        return round($statement['net_income'] - $dividends, 2);
    }

    public function balanceSheet(Carbon $asOf): array
    {
        $loansReceivable = round(
            Loan::query()->whereNotNull('disbursed_at')->get()->sum(fn (Loan $loan) => $loan->outstandingBalanceAsOf($asOf)),
            2
        );

        $memberSavings = round(
            SavingsAccount::query()->get()->sum(fn (SavingsAccount $account) => $account->balanceAsOf($asOf)),
            2
        );

        $memberShares = round(
            ShareAccount::query()->get()->sum(fn (ShareAccount $account) => $account->balanceAsOf($asOf)),
            2
        );

        $retainedEarnings = $this->retainedEarningsAsOf($asOf);

        $totalLiabilities = $memberSavings;
        $totalEquity = round($memberShares + $retainedEarnings, 2);

        // Assets must equal Liabilities + Equity — Cash is defined as
        // whatever makes that true, since it isn't tracked directly.
        $impliedCash = round($totalLiabilities + $totalEquity - $loansReceivable, 2);
        $totalAssets = round($loansReceivable + $impliedCash, 2);

        return [
            'as_of' => $asOf,
            'assets' => [
                ['label' => 'Loans Receivable (outstanding)', 'amount' => $loansReceivable],
                ['label' => 'Cash & Bank (implied — reconcile against bank statement)', 'amount' => $impliedCash],
            ],
            'total_assets' => $totalAssets,
            'liabilities' => [
                ['label' => 'Member Savings', 'amount' => $memberSavings],
            ],
            'total_liabilities' => $totalLiabilities,
            'equity' => [
                ['label' => 'Member Share Capital', 'amount' => $memberShares],
                ['label' => 'Retained Earnings', 'amount' => $retainedEarnings],
            ],
            'total_equity' => $totalEquity,
            'total_liabilities_and_equity' => round($totalLiabilities + $totalEquity, 2),
        ];
    }

    /**
     * Balance Sheet items as of FY end, Income Statement flows for the FY,
     * and Retained Earnings brought forward as of FY start — algebraically
     * guaranteed to balance (Retained Earnings roll-forward is exactly
     * Net Income minus Dividends, and Cash is the Balance Sheet's plug), so
     * a mismatch here would indicate a genuine bug, not rounding noise.
     */
    public function trialBalance(Carbon $fyStart, Carbon $fyEnd): array
    {
        $balanceSheet = $this->balanceSheet($fyEnd);
        $incomeStatement = $this->incomeStatement($fyStart, $fyEnd);
        $dividends = $this->shareDividendsDeclared($fyStart, $fyEnd);
        $retainedEarningsBroughtForward = $this->retainedEarningsAsOf($fyStart->copy()->subSecond());

        $debits = array_merge([
            ['label' => 'Loans Receivable', 'amount' => $balanceSheet['assets'][0]['amount']],
            ['label' => 'Cash & Bank (implied)', 'amount' => $balanceSheet['assets'][1]['amount']],
        ], $incomeStatement['expenses']);

        if ($dividends > 0) {
            $debits[] = ['label' => 'Share Dividends Declared', 'amount' => $dividends];
        }

        $credits = array_merge([
            ['label' => 'Member Savings', 'amount' => $balanceSheet['liabilities'][0]['amount']],
            ['label' => 'Member Share Capital', 'amount' => $balanceSheet['equity'][0]['amount']],
            ['label' => 'Retained Earnings (brought forward)', 'amount' => $retainedEarningsBroughtForward],
        ], $incomeStatement['income']);

        $totalDebits = round(array_sum(array_column($debits, 'amount')), 2);
        $totalCredits = round(array_sum(array_column($credits, 'amount')), 2);

        return [
            'period' => ['start' => $fyStart, 'end' => $fyEnd],
            'debits' => $debits,
            'credits' => $credits,
            'total_debits' => $totalDebits,
            'total_credits' => $totalCredits,
            'balances' => abs($totalDebits - $totalCredits) < 0.01,
        ];
    }
}
