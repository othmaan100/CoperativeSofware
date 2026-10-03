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
        $this->feeAmount = (string) Setting::get('application_form_fee', 5000);
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

    public function render()
    {
        return view('livewire.members.pay-application-fee')->layout('layouts.app');
    }
}
