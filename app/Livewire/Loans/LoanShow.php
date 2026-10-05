<?php

namespace App\Livewire\Loans;

use App\Models\Document;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class LoanShow extends Component
{
    public Loan $loan;

    public function mount(Loan $loan): void
    {
        abort_unless(Document::userCanView(Auth::user(), $loan), 403);

        $this->loan = $loan;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $this->loan->load(['member', 'product', 'guarantors.guarantorMember', 'tenureChangeRequests' => fn ($q) => $q->latest('requested_at')]);

        return view('livewire.loans.loan-show');
    }
}
