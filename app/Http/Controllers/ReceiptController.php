<?php

namespace App\Http\Controllers;

use App\Models\ApplicationFeePayment;
use App\Models\LoanRepaymentIntent;
use App\Models\VoluntaryDepositIntent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReceiptController extends Controller
{
    public function depositReceipt(VoluntaryDepositIntent $intent)
    {
        $user = Auth::user();
        abort_unless($intent->receipt_path, 404);
        abort_unless(
            $user->can('confirm_voluntary_deposit') || $intent->member->user_id === $user->id,
            403
        );

        return Storage::disk('local')->download($intent->receipt_path, $intent->receipt_original_filename);
    }

    /**
     * Printable receipt for a confirmed application (registration) fee —
     * for the applicant, and for officials who handle registrations.
     */
    public function applicationFeeReceipt(ApplicationFeePayment $payment)
    {
        $user = Auth::user();
        abort_unless($payment->isSuccessful(), 404);
        abort_unless(
            $payment->member->user_id === $user->id
                || $user->can('approve_applications')
                || $user->can('view_registration_fee_reports'),
            403
        );

        return view('receipts.application-fee', [
            'payment' => $payment->load(['member', 'recordedBy']),
        ]);
    }

    public function repaymentReceipt(LoanRepaymentIntent $intent)
    {
        $user = Auth::user();
        abort_unless($intent->receipt_path, 404);
        abort_unless(
            $user->can('confirm_loan_repayment') || $intent->member->user_id === $user->id,
            403
        );

        return Storage::disk('local')->download($intent->receipt_path, $intent->receipt_original_filename);
    }
}
