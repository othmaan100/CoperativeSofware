<?php

namespace App\Livewire\Reports;

use App\Models\ContributionBatch;
use App\Models\Member;
use App\Models\ReversalRequest;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use App\Models\WithdrawalCondition;
use App\Models\WithdrawalRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SavingsReports extends Component
{
    use WithPagination;

    public string $contributionSearch = '';

    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_savings_reports'), 403);
    }

    public function updatedContributionSearch(): void
    {
        $this->resetPage('contributionsPage');
    }

    /**
     * One row per member (excluding unapproved applicants) with their savings
     * transactions summed per type. Reversed transactions are left out, so a
     * contribution corrected via the reversal workflow doesn't count.
     */
    protected function memberContributionsQuery(): Builder
    {
        $notReversed = fn ($query) => $query->selectRaw('1')
            ->from('savings_transactions as rev')
            ->whereColumn('rev.reversed_transaction_id', 'savings_transactions.id');

        $totals = SavingsTransaction::query()
            ->join('savings_accounts as sa', 'sa.id', '=', 'savings_transactions.savings_account_id')
            ->leftJoin('contribution_batches as cb', 'cb.id', '=', 'savings_transactions.source_batch_id')
            ->whereIn('savings_transactions.type', ['contribution_deduction', 'opening_balance'])
            ->whereNotExists($notReversed)
            ->groupBy('sa.member_id')
            ->selectRaw("sa.member_id,
                SUM(CASE WHEN savings_transactions.type = 'contribution_deduction' THEN savings_transactions.amount ELSE 0 END) as total_contributed,
                SUM(CASE WHEN savings_transactions.type = 'contribution_deduction' THEN 1 ELSE 0 END) as contribution_count,
                MAX(CASE WHEN savings_transactions.type = 'contribution_deduction' THEN cb.period END) as last_period,
                SUM(CASE WHEN savings_transactions.type = 'opening_balance' THEN savings_transactions.amount ELSE 0 END) as opening_balance");

        $balances = SavingsAccount::query()
            ->groupBy('member_id')
            ->selectRaw('member_id, SUM(balance) as savings_balance');

        $search = trim($this->contributionSearch);

        return Member::query()
            ->where('members.status', '!=', 'pending')
            ->leftJoinSub($totals, 'totals', 'totals.member_id', '=', 'members.id')
            ->leftJoinSub($balances, 'balances', 'balances.member_id', '=', 'members.id')
            ->when($search !== '', fn ($query) => $query->where(fn ($q) => $q
                ->where('members.full_name', 'like', "%{$search}%")
                ->orWhere('members.staff_id', 'like', "%{$search}%")
                ->orWhere('members.ippis_number', 'like', "%{$search}%")
                ->orWhere('members.department', 'like', "%{$search}%")))
            ->select('members.*')
            ->selectRaw('COALESCE(totals.total_contributed, 0) as total_contributed')
            ->selectRaw('COALESCE(totals.contribution_count, 0) as contribution_count')
            ->selectRaw('totals.last_period as last_period')
            ->selectRaw('COALESCE(totals.opening_balance, 0) as opening_balance')
            ->selectRaw('COALESCE(balances.savings_balance, 0) as savings_balance')
            ->orderBy('members.full_name');
    }

    protected function memberContributionTotals(): object
    {
        return DB::query()
            ->fromSub($this->memberContributionsQuery()->reorder(), 'rows')
            ->selectRaw('COUNT(*) as members, SUM(approved_monthly_contribution) as monthly, SUM(opening_balance) as opening,
                SUM(total_contributed) as contributed, SUM(savings_balance) as balance')
            ->first();
    }

    protected function totalsByDepartment()
    {
        return SavingsAccount::query()
            ->join('members', 'members.id', '=', 'savings_accounts.member_id')
            ->selectRaw('members.department as department, SUM(savings_accounts.balance) as total')
            ->groupBy('members.department')
            ->orderByDesc('total')
            ->get();
    }

    protected function totalsByProduct()
    {
        return SavingsAccount::query()
            ->join('savings_products', 'savings_products.id', '=', 'savings_accounts.savings_product_id')
            ->selectRaw('savings_products.name as product, SUM(savings_accounts.balance) as total')
            ->groupBy('savings_products.name')
            ->orderByDesc('total')
            ->get();
    }

    protected function topSavers()
    {
        return SavingsAccount::with('member')
            ->orderByDesc('balance')
            ->limit(20)
            ->get();
    }

    protected function lowBalanceAlerts()
    {
        $minimumBalance = (float) (WithdrawalCondition::query()
            ->where('rule_type', 'minimum_balance')
            ->where('is_active', true)
            ->value('value') ?? 0);

        return SavingsAccount::with('member')
            ->where('balance', '<=', $minimumBalance * 1.2)
            ->orderBy('balance')
            ->get();
    }

    public function exportCsv(string $section): StreamedResponse
    {
        $filename = "savings-report-{$section}-".now()->format('Y-m-d_His').'.csv';

        return response()->streamDownload(function () use ($section) {
            $handle = fopen('php://output', 'w');

            match ($section) {
                'department' => $this->writeDepartmentCsv($handle),
                'product' => $this->writeProductCsv($handle),
                'top-savers' => $this->writeTopSaversCsv($handle),
                'member-contributions' => $this->writeMemberContributionsCsv($handle),
                'low-balance' => $this->writeLowBalanceCsv($handle),
                'batches' => $this->writeBatchesCsv($handle),
                'withdrawals' => $this->writeWithdrawalsCsv($handle),
                'reversals' => $this->writeReversalsCsv($handle),
                default => null,
            };

            fclose($handle);
        }, $filename);
    }

    protected function writeDepartmentCsv($handle): void
    {
        fputcsv($handle, ['Department', 'Total Savings']);
        foreach ($this->totalsByDepartment() as $row) {
            fputcsv($handle, [$row->department, $row->total]);
        }
    }

    protected function writeProductCsv($handle): void
    {
        fputcsv($handle, ['Product', 'Total Savings']);
        foreach ($this->totalsByProduct() as $row) {
            fputcsv($handle, [$row->product, $row->total]);
        }
    }

    protected function writeTopSaversCsv($handle): void
    {
        fputcsv($handle, ['Member', 'Staff ID', 'Account', 'Balance']);
        foreach ($this->topSavers() as $account) {
            fputcsv($handle, [$account->member->full_name, $account->member->staff_id, $account->account_no, $account->balance]);
        }
    }

    protected function writeMemberContributionsCsv($handle): void
    {
        fputcsv($handle, [
            'S/N', 'Staff ID', 'Member', 'IPPIS No.', 'Department', 'Date Joined', 'Status',
            'Monthly Contribution', 'Opening Balance', 'Total Contributions', 'No. of Contributions',
            'Last Contribution Month', 'Current Savings Balance',
        ]);

        $serial = 0;
        foreach ($this->memberContributionsQuery()->cursor() as $member) {
            fputcsv($handle, [
                ++$serial,
                $member->staff_id,
                $member->full_name,
                $member->ippis_number,
                $member->department,
                $member->membership_date?->format('Y-m-d'),
                ucfirst($member->status),
                $this->money($member->approved_monthly_contribution),
                $this->money($member->opening_balance),
                $this->money($member->total_contributed),
                $member->contribution_count,
                $member->last_period ? Carbon::createFromFormat('!Y-m', $member->last_period)->format('M Y') : '',
                $this->money($member->savings_balance),
            ]);
        }

        $totals = $this->memberContributionTotals();
        fputcsv($handle, ['', '', 'TOTAL ('.$totals->members.' members)', '', '', '', '',
            $this->money($totals->monthly), $this->money($totals->opening), $this->money($totals->contributed), '', '', $this->money($totals->balance)]);
    }

    protected function money($value): string
    {
        return number_format((float) $value, 2, '.', '');
    }

    protected function writeLowBalanceCsv($handle): void
    {
        fputcsv($handle, ['Member', 'Staff ID', 'Account', 'Balance']);
        foreach ($this->lowBalanceAlerts() as $account) {
            fputcsv($handle, [$account->member->full_name, $account->member->staff_id, $account->account_no, $account->balance]);
        }
    }

    protected function writeBatchesCsv($handle): void
    {
        fputcsv($handle, ['Period', 'Status', 'Records', 'Total Amount', 'Posted At']);
        foreach (ContributionBatch::latest()->get() as $batch) {
            fputcsv($handle, [$batch->period, $batch->status, $batch->total_records, $batch->total_amount, $batch->posted_at]);
        }
    }

    protected function writeWithdrawalsCsv($handle): void
    {
        fputcsv($handle, ['Member', 'Requested', 'Approved', 'Status', 'Requested At', 'Disbursed At']);
        foreach (WithdrawalRequest::with('member')->latest('requested_at')->get() as $wr) {
            fputcsv($handle, [$wr->member->full_name, $wr->requested_amount, $wr->approved_amount, $wr->status, $wr->requested_at, $wr->disbursed_at]);
        }
    }

    protected function writeReversalsCsv($handle): void
    {
        fputcsv($handle, ['Original Txn', 'Reason', 'Initiated By', 'Authorized By', 'Status']);
        foreach (ReversalRequest::with(['initiatedBy', 'authorizedBy'])->latest('requested_at')->get() as $rev) {
            fputcsv($handle, [$rev->original_transaction_id, $rev->reason, $rev->initiatedBy->name, $rev->authorizedBy?->name, $rev->status]);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.reports.savings-reports', [
            'byDepartment' => $this->totalsByDepartment(),
            'byProduct' => $this->totalsByProduct(),
            'topSavers' => $this->topSavers(),
            'memberContributions' => $this->memberContributionsQuery()->paginate(25, pageName: 'contributionsPage'),
            'contributionTotals' => $this->memberContributionTotals(),
            'lowBalance' => $this->lowBalanceAlerts(),
            'batches' => ContributionBatch::latest()->limit(10)->get(),
            'withdrawals' => WithdrawalRequest::with('member')->latest('requested_at')->limit(10)->get(),
            'reversals' => ReversalRequest::with(['initiatedBy', 'authorizedBy'])->latest('requested_at')->limit(10)->get(),
        ]);
    }
}
