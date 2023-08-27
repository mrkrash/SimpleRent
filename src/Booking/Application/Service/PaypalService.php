<?php

namespace App\Booking\Application\Service;

use App\Booking\Domain\Entity\Transaction;
use App\Booking\Domain\Exception\PaymentCheckoutException;
use App\Booking\Domain\Repository\TransactionRepositoryInterface;
use App\Booking\Domain\Service\PaymentServiceInterface;
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
        private readonly TransactionRepositoryInterface $transactionRepository,
    ) {
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
     * @param string $orderId
     * @param Transaction $transaction
     * @return bool
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws PaymentCheckoutException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function checkoutOrder(string $orderId, Transaction $transaction): bool
    {
        $responseBody = $this->paypalOrder->request('GET', '/v2/checkout/orders/' . $orderId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
        ]);

        if ($responseBody->getStatusCode() !== 200) {
            throw new PaymentCheckoutException();
        }

        $paypalOrder = $responseBody->toArray();

        if (
            $this->paidRightAmount($paypalOrder, $transaction)
            && $paypalOrder['intent'] === self::INTENT_CAPTURE
            && $paypalOrder['status'] === self::STATUS_APPROVED
        ) {
            if ($this->capturePayment($orderId, $transaction)) {
                $transaction->setTransportStatus(Transaction::STATUS_PAID);
                $this->transactionRepository->save($transaction);

                return true;
            }
        }

        return true;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function capturePayment(string $orderId, Transaction $transaction): bool
    {
        $responseBody = $this->paypalOrder->request('POST', '/v2/checkout/orders/' . $orderId . '/capture', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Paypal-Request-Id' => $transaction->getRequestId()
            ],
        ]);
        $responseHttpCode = $responseBody->getStatusCode();
        $response = $responseBody->toArray();

        if (
            $responseHttpCode !== 201
            || !array_key_exists('status', $response)
            || $response['status'] !== self::STATUS_COMPLETED
        ) {
            return false;
        }
        return true;
    }

    private function paidRightAmount(array $paypalOrder, Transaction $transaction): bool
    {
        // Check if the purchase currency is the right one
        if ($paypalOrder['purchase_units'][0]['amount']['currency_code'] !== 'EUR') {
            return false;
        }
        // Check if the amount paid is the right one
        if ((int) $paypalOrder['purchase_units'][0]['amount']['value'] !== $transaction->getAmount()) {
            $transaction->setTransportStatus(Transaction::STATUS_FRAUD_SUSPECTED);
            $this->transactionRepository->save($transaction);

            return false;
        }

        return true;
    }
}
