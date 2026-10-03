<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaystackService
{
    protected string $secretKey;

    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = (string) config('services.paystack.secret_key');
        $this->baseUrl = rtrim((string) config('services.paystack.base_url', 'https://api.paystack.co'), '/');
    }

    public function isConfigured(): bool
    {
        return $this->secretKey !== '';
    }

    /**
     * Start a hosted-checkout transaction. Returns Paystack's response data,
     * which includes `authorization_url` — redirect the browser there.
     */
    public function initializeTransaction(string $email, float $amountNaira, string $reference, string $callbackUrl): array
    {
        $this->ensureConfigured();

        $response = Http::withToken($this->secretKey)
            ->acceptJson()
            ->post("{$this->baseUrl}/transaction/initialize", [
                'email' => $email,
                'amount' => (int) round($amountNaira * 100),
                'reference' => $reference,
                'callback_url' => $callbackUrl,
                'currency' => 'NGN',
            ]);

        if (! $response->successful() || ! $response->json('status')) {
            throw new RuntimeException($response->json('message') ?? 'Unable to initialize payment with Paystack.');
        }

        return $response->json('data') ?? [];
    }

    /**
     * Confirm what actually happened to a transaction, straight from
     * Paystack's servers — never trust an amount/status from the browser
     * redirect or an unverified webhook payload alone.
     */
    public function verifyTransaction(string $reference): array
    {
        $this->ensureConfigured();

        $response = Http::withToken($this->secretKey)
            ->acceptJson()
            ->get("{$this->baseUrl}/transaction/verify/".rawurlencode($reference));

        if (! $response->successful()) {
            throw new RuntimeException($response->json('message') ?? 'Unable to verify payment with Paystack.');
        }

        return $response->json('data') ?? [];
    }

    public function verifyWebhookSignature(string $rawPayload, ?string $signature): bool
    {
        if (! $signature || ! $this->isConfigured()) {
            return false;
        }

        return hash_equals(hash_hmac('sha512', $rawPayload, $this->secretKey), $signature);
    }

    protected function ensureConfigured(): void
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Paystack is not configured yet. Set PAYSTACK_SECRET_KEY in .env.');
        }
    }
}
