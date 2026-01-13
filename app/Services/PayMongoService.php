<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayMongoService
{
    protected string $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.paymongo.secret_key');
    }

    /**
     * Create a PayMongo checkout session for a contract
     */
    public function createCheckoutSession(
        string $contractNumber,
        int $amountCents,
        string $successUrl,
        string $cancelUrl
    ): array {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'line_items' => [
                            [
                                'amount' => $amountCents,
                                'currency' => 'PHP',
                                'description' => "Payment for contract {$contractNumber}",
                                'name' => 'Contract Payment',
                                'quantity' => 1,
                            ],
                        ],
                        'payment_method_types' => [
                            'card',
                            'paymaya',
                            'qrph',
                            'billease',
                            'grab_pay',
                            'dob',
                        ],
                        'success_url' => $successUrl,
                        'cancel_url' => $cancelUrl,
                    ],
                ],
            ]);

        if (! $response->successful()) {
            throw new \Exception('Failed to create PayMongo checkout session');
        }

        return [
            'id' => $response['data']['id'],
            'checkout_url' => $response['data']['attributes']['checkout_url'],
        ];
    }
}
