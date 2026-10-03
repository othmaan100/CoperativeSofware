<?php

namespace App\Livewire\Savings;

use App\Models\SavingsAccount;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SavingsStatement extends Component
{
    public SavingsAccount $account;

    public string $from = '';

    public string $to = '';

    public function mount(SavingsAccount $account): void
    {
        $this->authorizeAccess($account);
        $this->account = $account;
        $this->from = now()->subMonths(3)->format('Y-m-d');
        $this->to = now()->format('Y-m-d');
    }

    protected function authorizeAccess(SavingsAccount $account): void
    {
        $user = Auth::user();
        $isOwner = $account->member->user_id === $user->id;

        abort_unless($isOwner || $user->can('view_savings_reports') || $user->can('treasurer_review_withdrawal') || $user->can('chairman_authorize_withdrawal'), 403);
    }

    protected function transactionsQuery()
    {
        return $this->account->transactions()
            ->whereDate('posted_at', '>=', $this->from)
            ->whereDate('posted_at', '<=', $this->to)
            ->with('reversedTransaction')
            ->oldest('posted_at');
    }

    public function downloadPdf()
    {
        $transactions = $this->transactionsQuery()->get();

        $pdf = Pdf::loadView('pdf.savings-statement', [
            'account' => $this->account,
            'transactions' => $transactions,
            'from' => $this->from,
            'to' => $this->to,
        ]);

        $safeAccountNo = str_replace(['/', '\\'], '-', $this->account->account_no);

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            "statement-{$safeAccountNo}.pdf"
        );
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.savings.savings-statement', [
            'transactions' => $this->transactionsQuery()->get(),
        ]);
    }
}
