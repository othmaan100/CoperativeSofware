<?php

namespace App\Livewire\Loans;

use App\Models\LoanGuarantor;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class GuarantorRequests extends Component
{
    public Member $member;

    public function mount(): void
    {
        $this->member = Auth::user()->member()->firstOrFail();
    }

    protected function checkMinimumGuarantorsMet(\App\Models\Loan $loan): void
    {
        $accepted = $loan->guarantors()->where('status', LoanGuarantor::STATUS_ACCEPTED)->count();

        if ($loan->status === 'pending_guarantor' && $accepted >= (int) $loan->product->min_guarantors) {
            $loan->update(['status' => 'pending']);
        }
    }

    public function accept(int $guarantorId): void
    {
        $guarantor = LoanGuarantor::with('loan.product')->findOrFail($guarantorId);

        abort_unless($guarantor->guarantor_member_id === $this->member->id, 403);

        if ($guarantor->status !== LoanGuarantor::STATUS_INVITED) {
            return;
        }

        $guarantor->update(['status' => LoanGuarantor::STATUS_ACCEPTED, 'accepted_at' => now()]);
        $this->checkMinimumGuarantorsMet($guarantor->loan);

        session()->flash('status', 'You have accepted the guarantee request.');
    }

    public function decline(int $guarantorId): void
    {
        $guarantor = LoanGuarantor::with('loan')->findOrFail($guarantorId);

        abort_unless($guarantor->guarantor_member_id === $this->member->id, 403);

        if ($guarantor->status !== LoanGuarantor::STATUS_INVITED) {
            return;
        }

        $guarantor->update(['status' => LoanGuarantor::STATUS_DECLINED, 'declined_at' => now()]);
        $guarantor->loan->update(['status' => 'guarantor_declined']);

        session()->flash('status', 'You have declined the guarantee request. The applicant has been notified.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.loans.guarantor-requests', [
            'invitations' => LoanGuarantor::with(['loan.member', 'loan.product'])
                ->where('guarantor_member_id', $this->member->id)
                ->where('status', LoanGuarantor::STATUS_INVITED)
                ->latest()
                ->get(),
            'exposures' => LoanGuarantor::with(['loan.member', 'loan.product'])
                ->where('guarantor_member_id', $this->member->id)
                ->where('status', LoanGuarantor::STATUS_ACCEPTED)
                ->latest()
                ->get(),
        ]);
    }
}
