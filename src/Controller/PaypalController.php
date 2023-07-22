<?php

namespace App\Controller;

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

    #[Route('/rest/paypal/create', name: 'paypal_create_order', methods: ['POST'])]
    public function create(
        Request $request,
        HttpClientInterface $paypalOrder,
        BookingRepository $bookingRepository,
        CustomerRepository $customerRepository,
        TransactionRepository $transactionRepository,
    ): Response {
        $rate = $request->getSession()->get('rate');
        $products = $request->getSession()->get('products');
        $start = $request->getSession()->get('start');
        $end = $request->getSession()->get('end');
        $notes = $request->getSession()->get('notes');
        $customer = $request->getPayload()->all()['customer'];

        $customer = (new Customer())
            ->setFirstname($customer['firstname'])
            ->setLastname($customer['lastname'])
            ->setPhone($customer['phone'])
            ->setEmail($customer['email'])
        ;
        $customerRepository->save($customer);
        $booking = (new Booking())
            ->setCustomer($customer)
            ->setDateStart($start)
            ->setDateEnd($end)
            ->setNotes($notes)
            ->setProducts($products)
        ;
        $bookingRepository->save($booking, true);

        $responseBody = $paypalOrder->request('POST', '', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
            ],
            'body' => json_encode([
                "purchase_units" => [
                    ["amount" => [
                        "currency_code" => "EUR",
                        "value" => $rate
                    ],
                    'reference_id' => $booking->getId(),
                ]],
                'intent' => 'AUTHORIZE',
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
            ->setAmount($rate)
            ->setLevied(0)
            ->setBooking($booking)
        ;
        $transactionRepository->save($transaction, true);

        return new JsonResponse($order);
    }

    #[Route('/paypal/landing', name: 'paypal_landing')]
    public function landing(): void
    {}
    #[Route('/paypal/cancel', name: 'paypal_cancel')]
    public function cancel(): void
    {}
}
