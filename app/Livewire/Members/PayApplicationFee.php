<?php

namespace App\Livewire\Members;

use App\Models\ApplicationFeePayment;
use App\Models\Member;
use App\Models\Setting;
use App\Services\PaystackService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class PayApplicationFee extends Component
{
    public Member $member;

    public string $feeAmount;

    public function mount(): void
    {
        $this->member = Auth::user()->member()->with('applicationFeePayments')->firstOrFail();
        $this->feeAmount = (string) ApplicationFeePayment::currentFee();
    }

    public function payNow(PaystackService $paystack): void
    {
        if ($this->member->application_fee_paid) {
            session()->flash('status', 'Your application fee is already paid.');
            $this->redirectRoute('my-application', navigate: true);

            return;
        }

        if (! $paystack->isConfigured()) {
            session()->flash('error', 'Online payment is not set up yet. Please contact the Treasurer to arrange payment.');

            return;
        }

        // Before charging again, ask Paystack about earlier attempts that never
        // came back (browser closed, bank transfer still clearing), so nobody
        // pays the fee twice.
        foreach ($this->member->applicationFeePayments()->where('status', ApplicationFeePayment::STATUS_PENDING)->get() as $earlier) {
            $this->refreshFromPaystack($earlier, $paystack);
        }
        $this->member->refresh();

        if ($this->member->application_fee_paid) {
            session()->flash('status', 'An earlier payment has now been confirmed. Your application fee is paid — you do not need to pay again.');
            $this->redirectRoute('my-application', navigate: true);

            return;
        }

        if ($this->member->applicationFeePayments()->where('status', ApplicationFeePayment::STATUS_PENDING)->where('initiated_at', '>=', now()->subMinutes(30))->exists()) {
            session()->flash('error', 'An earlier payment is still being processed by your bank. Please wait a few minutes and press "Check payment" before paying again.');

            return;
        }

        // Paystack rejects references containing "/" — application_no is
        // formatted like FCET/CSL/00043, so swap slashes for dashes.
        $safeApplicationNo = str_replace('/', '-', $this->member->application_no);
        $reference = 'FEE-'.$safeApplicationNo.'-'.Str::upper(Str::random(8));

        $payment = ApplicationFeePayment::create([
            'member_id' => $this->member->id,
            'reference' => $reference,
            'amount' => $this->feeAmount,
            'status' => ApplicationFeePayment::STATUS_PENDING,
            'initiated_at' => now(),
        ]);

        try {
            $data = $paystack->initializeTransaction(
                email: $this->member->email,
                amountNaira: (float) $this->feeAmount,
                reference: $reference,
                callbackUrl: route('payments.paystack.callback'),
            );
        } catch (\Throwable $e) {
            $payment->update(['status' => ApplicationFeePayment::STATUS_FAILED]);
            session()->flash('error', 'Could not start payment: '.$e->getMessage());

            return;
        }

        $this->redirect($data['authorization_url']);
    }

    /**
     * Ask Paystack again about one of the applicant's own attempts — for when
     * they paid but never made it back to the site, or a transfer was clearing.
     */
    public function checkPayment(int $paymentId, PaystackService $paystack): void
    {
        $payment = $this->member->applicationFeePayments()->findOrFail($paymentId);

        if ($payment->isSuccessful()) {
            session()->flash('status', 'This payment is already confirmed.');

            return;
        }

        if (! $this->refreshFromPaystack($payment, $paystack)) {
            session()->flash('error', 'We could not reach Paystack just now. Please try again in a minute.');

            return;
        }

        $payment->refresh();
        $this->member->refresh();

        if ($payment->isSuccessful()) {
            session()->flash('status', 'Payment confirmed. Your application fee has been paid.');
            $this->redirectRoute('my-application', navigate: true);
        } elseif ($payment->isPending()) {
            session()->flash('status', 'Paystack says this payment is still being processed. Please check again in a few minutes.');
        } else {
            session()->flash('error', 'Paystack shows this payment was not completed, so it does not count. You can pay again.');
        }
    }

    protected function refreshFromPaystack(ApplicationFeePayment $payment, PaystackService $paystack): bool
    {
        try {
            $payment->applyVerification($paystack->verifyTransaction($payment->reference));

            return true;
        } catch (\Throwable $e) {
            report($e);

            return false;
        }
    }

    public function render()
    {
        return view('livewire.members.pay-application-fee')->layout('layouts.app');
    }
}
