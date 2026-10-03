<?php

namespace App\Http\Controllers;

use App\Models\ApplicationFeePayment;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class PaystackController extends Controller
{
    /**
     * Browser redirect back from Paystack's hosted checkout. This is the
     * primary confirmation path for the member's own UX; the webhook below
     * is the reliable fallback in case the browser never makes it back here.
     */
    public function callback(Request $request, PaystackService $paystack): RedirectResponse
    {
        $reference = $request->query('reference') ?? $request->query('trxref');

        $payment = $reference ? ApplicationFeePayment::where('reference', $reference)->first() : null;

        if (! $payment) {
            return redirect()->route('my-application')
                ->with('error', 'We could not find that payment reference. If you were charged, contact the Treasurer.');
        }

        if ($payment->isSuccessful()) {
            return redirect()->route('my-application')->with('status', 'Payment confirmed. Your application fee has been paid.');
        }

        try {
            $data = $paystack->verifyTransaction($payment->reference);
        } catch (\Throwable $e) {
            Log::warning('Paystack verify failed on callback', ['reference' => $payment->reference, 'error' => $e->getMessage()]);

            return redirect()->route('my-application')
                ->with('error', 'We could not confirm your payment yet. If you completed payment, it will reflect shortly — please refresh this page in a minute.');
        }

        $payment->applyVerification($data);

        return $payment->fresh()->isSuccessful()
            ? redirect()->route('my-application')->with('status', 'Payment confirmed. Your application fee has been paid.')
            : redirect()->route('my-application.pay-fee')->with('error', 'Payment was not successful. Please try again.');
    }

    /**
     * Server-to-server confirmation from Paystack — the reliable path that
     * doesn't depend on the member's browser making it back to our site.
     */
    public function webhook(Request $request, PaystackService $paystack): \Illuminate\Http\Response
    {
        $signature = $request->header('x-paystack-signature');

        if (! $paystack->verifyWebhookSignature($request->getContent(), $signature)) {
            Log::warning('Paystack webhook signature verification failed.');

            return response('invalid signature', 400);
        }

        $event = $request->input('event');
        $reference = $request->input('data.reference');

        if ($event === 'charge.success' && $reference) {
            $payment = ApplicationFeePayment::where('reference', $reference)->first();

            if ($payment && ! $payment->isSuccessful()) {
                try {
                    $data = $paystack->verifyTransaction($reference);
                    $payment->applyVerification($data);
                } catch (\Throwable $e) {
                    Log::error('Paystack webhook verify failed', ['reference' => $reference, 'error' => $e->getMessage()]);
                }
            }
        }

        return response('ok', 200);
    }
}
