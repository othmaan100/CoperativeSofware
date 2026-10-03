<?php

namespace App\Livewire\Reports;

use App\Models\ContributionBatch;
use App\Models\ReversalRequest;
use App\Models\SavingsAccount;
use App\Models\WithdrawalCondition;
use App\Models\WithdrawalRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SavingsReports extends Component
{
    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_savings_reports'), 403);
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
            'lowBalance' => $this->lowBalanceAlerts(),
            'batches' => ContributionBatch::latest()->limit(10)->get(),
            'withdrawals' => WithdrawalRequest::with('member')->latest('requested_at')->limit(10)->get(),
            'reversals' => ReversalRequest::with(['initiatedBy', 'authorizedBy'])->latest('requested_at')->limit(10)->get(),
        ]);
    }
}
