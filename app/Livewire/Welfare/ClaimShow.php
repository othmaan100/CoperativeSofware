<?php

namespace App\Livewire\Welfare;

use App\Models\ActivityLog;
use App\Models\WelfareClaim;
use App\Models\WelfareFund;
use App\Notifications\WelfareClaimAuthorizationDecisionNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ClaimShow extends Component
{
    public WelfareClaim $claim;

    public bool $showDeclineForm = false;

    public string $declineNote = '';

    public string $paymentReference = '';

    public function mount(WelfareClaim $claim): void
    {
        $user = Auth::user();
        abort_unless(
            $user->can('initiate_welfare_claim')
                || $user->can('authorize_welfare_claim')
                || $user->can('disburse_welfare_claim')
                || $user->can('view_welfare_reports'),
            403
        );

        $this->claim = $claim;
    }

    public function authorizeClaim(): void
    {
        abort_unless(Auth::user()->can('authorize_welfare_claim'), 403);
        abort_unless($this->claim->status === WelfareClaim::STATUS_PENDING, 400);

        $this->claim->update([
            'status' => WelfareClaim::STATUS_CHAIRMAN_AUTHORIZED,
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
        ]);

        ActivityLog::record('welfare.claim_authorized', "Authorized welfare claim {$this->claim->claim_no}.", $this->claim);

        $this->claim->initiatedBy?->notify(new WelfareClaimAuthorizationDecisionNotification($this->claim, true));

        session()->flash('status', "Claim {$this->claim->claim_no} authorized. It can now be disbursed.");
    }

    public function openDeclineForm(): void
    {
        $this->showDeclineForm = true;
        $this->declineNote = '';
    }

    public function closeDeclineForm(): void
    {
        $this->showDeclineForm = false;
    }

    public function decline(): void
    {
        abort_unless(Auth::user()->can('authorize_welfare_claim'), 403);
        abort_unless($this->claim->status === WelfareClaim::STATUS_PENDING, 400);

        $this->validate(['declineNote' => ['required', 'string', 'max:255']]);

        $this->claim->update([
            'status' => WelfareClaim::STATUS_CHAIRMAN_DECLINED,
            'chairman_reviewed_by' => Auth::id(),
            'chairman_reviewed_at' => now(),
            'chairman_note' => $this->declineNote,
        ]);

        ActivityLog::record('welfare.claim_declined', "Declined welfare claim {$this->claim->claim_no}: {$this->declineNote}", $this->claim);

        $this->claim->initiatedBy?->notify(new WelfareClaimAuthorizationDecisionNotification($this->claim, false));

        $this->closeDeclineForm();
        session()->flash('status', "Claim {$this->claim->claim_no} declined.");
    }

    public function disburse(): void
    {
        abort_unless(Auth::user()->can('disburse_welfare_claim'), 403);
        abort_unless($this->claim->status === WelfareClaim::STATUS_CHAIRMAN_AUTHORIZED, 400);

        $this->validate(['paymentReference' => ['nullable', 'string', 'max:255']]);

        $fund = WelfareFund::singleton();
        $fund->recordTransaction(
            type: WelfareFund::TYPE_PAYOUT,
            amount: (float) $this->claim->amount,
            description: "Death benefit disbursed for claim {$this->claim->claim_no} ({$this->claim->member->full_name}).",
            postedBy: Auth::id(),
            claimId: $this->claim->id,
        );

        $this->claim->update([
            'status' => WelfareClaim::STATUS_DISBURSED,
            'disbursed_by' => Auth::id(),
            'disbursed_at' => now(),
            'payment_reference' => $this->paymentReference ?: null,
        ]);

        ActivityLog::record(
            'welfare.claim_disbursed',
            "Disbursed ₦".number_format((float) $this->claim->amount, 2)." for welfare claim {$this->claim->claim_no}.",
            $this->claim,
            ['amount' => (float) $this->claim->amount]
        );

        session()->flash('status', "Claim {$this->claim->claim_no} marked as disbursed.");
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.welfare.claim-show', [
            'fundBalance' => (float) WelfareFund::singleton()->balance,
        ]);
    }
}
