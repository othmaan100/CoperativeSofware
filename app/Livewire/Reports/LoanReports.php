<?php

namespace App\Livewire\Reports;

use App\Models\Loan;
use App\Models\LoanGuarantor;
use App\Models\LoanRepaymentBatch;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LoanReports extends Component
{
    public function mount(): void
    {
        abort_unless(Auth::user()->can('view_loan_reports'), 403);
    }

    protected function portfolioByProduct()
    {
        return Loan::query()
            ->join('loan_products', 'loan_products.id', '=', 'loans.loan_product_id')
            ->whereIn('loans.status', Loan::ACTIVE_STATUSES)
            ->selectRaw('loan_products.name as product, COUNT(*) as loan_count, SUM(loans.principal_amount) as total_disbursed, SUM(loans.outstanding_balance) as total_outstanding')
            ->groupBy('loan_products.name')
            ->get();
    }

    protected function overdueLoans()
    {
        return Loan::with(['member', 'product'])
            ->whereIn('status', ['overdue', 'defaulted'])
            ->orderByDesc('defaulted_at')
            ->get()
            ->map(function (Loan $loan) {
                $oldest = $loan->schedules()->where('status', 'overdue')->min('due_date');
                $loan->days_overdue = $oldest ? now()->diffInDays($oldest) : 0;

                return $loan;
            });
    }

    protected function guarantorExposure()
    {
        return LoanGuarantor::with(['guarantorMember', 'loan.member'])
            ->where('status', LoanGuarantor::STATUS_ACCEPTED)
            ->latest()
            ->limit(50)
            ->get();
    }

    protected function interestSplit()
    {
        return Loan::query()
            ->whereIn('status', array_merge(Loan::ACTIVE_STATUSES, ['closed']))
            ->selectRaw('SUM(interest_admin_amount) as admin_total, SUM(interest_profit_amount) as profit_total')
            ->first();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.reports.loan-reports', [
            'portfolio' => $this->portfolioByProduct(),
            'overdue' => $this->overdueLoans(),
            'guarantorExposure' => $this->guarantorExposure(),
            'interestSplit' => $this->interestSplit(),
            'batches' => LoanRepaymentBatch::latest()->limit(10)->get(),
            'legacyCount' => Loan::where('is_legacy_import', true)->count(),
            'systemCount' => Loan::where('is_legacy_import', false)->count(),
        ]);
    }
}
