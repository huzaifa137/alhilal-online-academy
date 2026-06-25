<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class MarzPayService
{
    protected string $baseUrl;
    protected string $authHeader;

    public function __construct()
    {
        $this->baseUrl    = config('marzpay.base_url', 'https://wallet.wearemarz.com/api/v1');
        $this->authHeader = 'Basic ' . config('marzpay.base64_credentials');
    }

    /**
     * Initiate a mobile money collection (MTN or Airtel).
     *
     * @param  int    $amount        Amount in UGX
     * @param  string $phoneNumber   Phone with country code e.g. +256712345678
     * @param  string $description   Human-readable description
     * @param  string $callbackUrl   Your webhook URL
     * @param  string|null $reference UUID reference (generated if not supplied)
     * @return array  ['success' => bool, 'data' => ..., 'message' => ...]
     */
    public function collectMobileMoney(
        int    $amount,
        string $phoneNumber,
        string $description,
        string $callbackUrl,
        ?string $reference = null
    ): array {
        $reference = $reference ?? (string) Uuid::uuid4();

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->authHeader,
                'Accept'        => 'application/json',
            ])->asForm()->post("{$this->baseUrl}/collect-money", [
                'amount'       => $amount,
                'phone_number' => $phoneNumber,
                'country'      => 'UG',
                'reference'    => $reference,
                'description'  => $description,
                'callback_url' => $callbackUrl,
            ]);

            $body = $response->json();

            if ($response->successful() && ($body['status'] ?? '') === 'success') {
                return [
                    'success'   => true,
                    'reference' => $reference,
                    'uuid'      => $body['data']['transaction']['uuid'] ?? null,
                    'status'    => $body['data']['transaction']['status'] ?? 'processing',
                    'message'   => $body['message'] ?? 'Collection initiated successfully.',
                    'raw'       => $body,
                ];
            }

            Log::error('MarzPay collectMobileMoney failed', ['body' => $body, 'status' => $response->status()]);
            return [
                'success' => false,
                'message' => $body['message'] ?? 'Payment initiation failed.',
                'raw'     => $body,
            ];

        } catch (\Throwable $e) {
            Log::error('MarzPay collectMobileMoney exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Could not reach payment gateway. Please try again.',
            ];
        }
    }

    /**
     * Initiate a card payment collection.
     * Returns a redirect_url that the customer must be sent to.
     *
     * @param  int    $amount
     * @param  string $description
     * @param  string $callbackUrl
     * @param  string|null $reference
     * @return array  ['success' => bool, 'redirect_url' => ..., ...]
     */
    public function collectCard(
        int    $amount,
        string $description,
        string $callbackUrl,
        ?string $reference = null
    ): array {
        $reference = $reference ?? (string) Uuid::uuid4();

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->authHeader,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ])->post("{$this->baseUrl}/collect-money", [
                'amount'       => $amount,
                'method'       => 'card',
                'reference'    => $reference,
                'country'      => 'UG',
                'description'  => $description,
                'callback_url' => $callbackUrl,
            ]);

            $body = $response->json();

            if ($response->successful() && ($body['status'] ?? '') === 'success') {
                return [
                    'success'      => true,
                    'reference'    => $reference,
                    'uuid'         => $body['data']['transaction']['uuid'] ?? null,
                    'redirect_url' => $body['data']['redirect_url'] ?? null,
                    'message'      => $body['message'] ?? 'Card payment initiated.',
                    'raw'          => $body,
                ];
            }

            Log::error('MarzPay collectCard failed', ['body' => $body]);
            return [
                'success' => false,
                'message' => $body['message'] ?? 'Card payment initiation failed.',
                'raw'     => $body,
            ];

        } catch (\Throwable $e) {
            Log::error('MarzPay collectCard exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Could not reach payment gateway. Please try again.',
            ];
        }
    }

    /**
     * Create a hosted payment link (for sharing or embedding).
     */
    public function createPaymentLink(
        string $title,
        int    $amount,
        string $description,
        string $redirectUrl,
        string $callbackUrl
    ): array {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->authHeader,
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ])->post("{$this->baseUrl}/payment-links", [
                'title'              => $title,
                'type'               => 'payment',
                'amount'             => $amount,
                'is_fixed'           => true,
                'currency'           => 'UGX',
                'description'        => $description,
                'redirect_url'       => $redirectUrl,
                'callback_url'       => $callbackUrl,
                'country'            => 'UG',
                'collection_methods' => ['mobile_money', 'card'],
            ]);

            $body = $response->json();

            if ($response->successful() && ($body['success'] ?? false)) {
                return [
                    'success'     => true,
                    'payment_url' => $body['data']['payment_url'] ?? null,
                    'uuid'        => $body['data']['uuid'] ?? null,
                    'raw'         => $body,
                ];
            }

            Log::error('MarzPay createPaymentLink failed', ['body' => $body]);
            return [
                'success' => false,
                'message' => $body['message'] ?? 'Failed to create payment link.',
            ];

        } catch (\Throwable $e) {
            Log::error('MarzPay createPaymentLink exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Could not reach payment gateway.',
            ];
        }
    }

    /**
     * Get collection/transaction details by UUID.
     */
    public function getTransaction(string $uuid): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->authHeader,
                'Accept'        => 'application/json',
            ])->get("{$this->baseUrl}/collect-money/{$uuid}");

            $body = $response->json();

            if ($response->successful()) {
                return ['success' => true, 'data' => $body['data'] ?? $body, 'raw' => $body];
            }

            return ['success' => false, 'message' => $body['message'] ?? 'Transaction not found.'];

        } catch (\Throwable $e) {
            Log::error('MarzPay getTransaction exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Could not reach payment gateway.'];
        }
    }
}
