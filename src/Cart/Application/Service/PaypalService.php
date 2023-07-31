<?php

namespace App\Cart\Application\Service;

use App\Cart\Domain\Exception\PaymentCheckoutException;
use App\Cart\Domain\Service\PaymentServiceInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function array_key_exists;

class PaypalService implements PaymentServiceInterface
{
    public const INTENT_AUTHORIZE = 'AUTHORIZE';
    public const INTENT_CAPTURE = 'CAPTURE';

    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_COMPLETED = 'COMPLETED';
    private mixed $accessToken;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function __construct(
        HttpClientInterface $paypalAuth,
        private readonly HttpClientInterface $paypalOrder,
    )
    {
        $responseBody = $paypalAuth->request('POST', '', [
            'body' => 'grant_type=client_credentials',
        ]);

        $this->accessToken = $responseBody->toArray()['access_token'];
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function createOrder(int $amount, int $refId, string $returnUrl, string $cancelUrl): array
    {
        return $this->paypalOrder->request('POST', '', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
            'body' => json_encode([
                'intent' => 'CAPTURE',
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "EUR",
                            "value" => $amount,
                        ],
                        'reference_id' => $refId,
                    ]
                ],
                'payment_source' => [
                    'paypal' => [
                        'experience_context' => [
                            'brand_name' => 'MC Rent Bike Ragusa',
                            'return_url' => $returnUrl,
                            'cancel_url' => $cancelUrl,
                        ]
                    ]
                ]
            ]),
        ])->toArray();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws PaymentCheckoutException
     */
    public function checkoutOrder(string $orderId): bool
    {
        $responseBody = $this->paypalOrder->request('GET', '/v2/checkout/orders/' . $orderId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
        ]);

        if ($responseBody->getStatusCode() !== 200) {
            throw new PaymentCheckoutException();
        }

        return true;
    }

    public function captureOrder(string $orderId, string $transactionId): bool
    {
        $responseBody = $this->paypalOrder->request('POST', '/v2/checkout/orders/' . $orderId . '/capture', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Paypal-Request-Id' => $transactionId
            ],
        ]);
        $responseHttpCode = $responseBody->getStatusCode();
        $response = $responseBody->toArray();

        if ($responseHttpCode !== 201
            || !array_key_exists('status', $response)
            || $response['status'] !== self::STATUS_COMPLETED
        ) {
            return false;
        }
        return true;
    }
}