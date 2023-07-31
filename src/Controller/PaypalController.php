<?php

namespace App\Controller;

use App\Cart\Application\Service\CartService;
use App\Cart\Domain\Service\PaymentServiceInterface;
use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\Transaction;
use App\Repository\BookingRepository;
use App\Repository\CustomerRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public function __construct(
        private readonly PaymentServiceInterface $paymentService
    ) {
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

        $order = $this->paymentService->createOrder(
            $cart->getRate(),
            $booking->getId(),
            $request->server->get('HTTP_HOST') . $this->generateUrl('paypal_landing'),
            $request->server->get('HTTP_HOST') . $this->generateUrl('paypal_cancel'),
        );

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
    public function capture(
        Request $request,
        TransactionRepository $transactionRepository
    ) {
        $order = $request->getPayload()->all()['order'];
        $transacion = $transactionRepository->findOneByTransportId($order['orderID']);
        if (
            $this->paymentService->checkoutOrder($order['orderID']) &&
            $this->paymentService->captureOrder($order['orderID'], $transacion->getRequestId())
        ) {
            return new RedirectResponse('/paypal/landing');
        }

        return new Response();//success, redirect to thank's page
    }

    #[Route('/paypal/landing', name: 'paypal_landing')]
    public function landing(): Response
    {
        return $this->render('rent/success.html.twig');
    }

    #[Route('/paypal/cancel', name: 'paypal_cancel')]
    public function cancel(): void
    {}
}
