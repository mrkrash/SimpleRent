<?php

namespace App\Controller;

use App\Cart\Application\Service\CartService;
use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\Transaction;
use App\Repository\BookingRepository;
use App\Repository\CustomerRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PaypalController extends AbstractController
{
    public const INTENT_AUTHORIZE = 'AUTHORIZE';
    public const INTENT_CAPTURE = 'CAPTURE';

    public const STATUS_APPROVED = 'APPROVED';
    public const STATUS_COMPLETED = 'COMPLETED';
    private string $accessToken;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function __construct(
        HttpClientInterface $paypalAuth,
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
    #[Route('/rest/paypal/create', name: 'paypal_create_order', methods: ['POST'])]
    public function create(
        Request $request,
        HttpClientInterface $paypalOrder,
        CartService $cartService,
        BookingRepository $bookingRepository,
        CustomerRepository $customerRepository,
        TransactionRepository $transactionRepository,
    ): Response {
        $cart = $cartService->handle();
        $customer = $request->getPayload()->all()['customer'];

        $customer = (new Customer())
            ->setFirstname($customer['firstname'])
            ->setLastname($customer['lastname'])
            ->setPhone($customer['phone'])
            ->setEmail($customer['email'])
            ->setNewsletter($customer['newsletter'])
            ->setPrivacy($customer['privacy'])
        ;
        $customerRepository->save($customer);
        $booking = (new Booking())
            ->setCustomer($customer)
            ->setDateStart($cart->getDateStart())
            ->setDateEnd($cart->getDateEnd())
            ->setProducts($cart->getCartItems()->toArray())
            ->setRate($cart->getRate())
        ;
        $bookingRepository->save($booking, true);

        $responseBody = $paypalOrder->request('POST', '', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
            'body' => json_encode([
                'intent' => 'CAPTURE',
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "EUR",
                            "value" => $cart->getRate(),
                        ],
                        'reference_id' => $booking->getId(),
                    ]
                ],
                'payment_source' => [
                    'paypal' => [
                        'experience_context' => [
                            'brand_name' => 'MC Rent Bike Ragusa',
                            'return_url' => $request->server->get('HTTP_HOST') . $this->generateUrl('paypal_landing'),
                            'cancel_url' => $request->server->get('HTTP_HOST') . $this->generateUrl('paypal_cancel'),
                        ]
                    ]
                ]
            ]),
        ]);
        $order = $responseBody->toArray();

        $transaction = (new Transaction())
            ->setTransportId($order['id'])
            ->setTransportStatus($order['status'])
            ->setTransportDetails($order)
            ->setTransport('paypal')
            ->setAmount($cart->getRate())
            ->setLevied(0)
            ->setBooking($booking)
        ;
        $transactionRepository->save($transaction, true);

        return new JsonResponse($order);
    }

    #[Route('/rest/paypal/capture', name: 'paypal-capture', methods: ['POST'])]
    public function capture(Request $request, HttpClientInterface $paypalOrder, TransactionRepository $transactionRepository)
    {
        $order = $request->getPayload()->all()['order'];
        $responseBody = $paypalOrder->request('GET', '/v2/checkout/orders/' . $order['orderID'], [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
        ]);

        $responseHttpCode = $responseBody->getStatusCode();
        $response = $responseBody->toArray();
        if ($responseHttpCode !== 200) {
            return false;
        }

        $paypalOrderResult = $responseBody->toArray();
        $transacion = $transactionRepository->findOneByTransportId($order['orderID']);
        $responseBody = $paypalOrder->request('POST', '/v2/checkout/orders/' . $order['orderID'] . '/capture', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Paypal-Request-Id' => $transacion->getRequestId()
            ],
        ]);

        $responseHttpCode = $responseBody->getStatusCode();

        $response = $responseBody->toArray();

        if ($responseHttpCode !== 201
            || !\array_key_exists('status', $response)
            || $response['status'] !== self::STATUS_COMPLETED
        ) {
            return false;
        }

        return new Response();//success, redirect to thank's page
    }

    #[Route('/paypal/landing', name: 'paypal_landing')]
    public function landing(): void
    {}
    #[Route('/paypal/cancel', name: 'paypal_cancel')]
    public function cancel(): void
    {}
}
