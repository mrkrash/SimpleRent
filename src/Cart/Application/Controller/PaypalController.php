<?php

namespace App\Cart\Application\Controller;

use App\Cart\Application\Service\CartService;
use App\Cart\Domain\Entity\Transaction;
use App\Cart\Domain\Service\PaymentServiceInterface;
use App\Cart\Infrastructure\Repository\TransactionRepository;
use App\Entity\Booking;
use App\Entity\Customer;
use App\Repository\BookingRepository;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[Route('/paypal')]
class PaypalController extends AbstractController
{
    public function __construct(
        private readonly PaymentServiceInterface $paymentService
    ) {
    }

    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/create', name: 'paypal_create_order', methods: ['POST'])]
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

    #[Route('/capture', name: 'paypal-capture', methods: ['POST'])]
    public function capture(
        Request $request,
        TransactionRepository $transactionRepository
    ) {
        $order = $request->getPayload()->all()['order'];
        $transaction = $transactionRepository->findOneByTransportId($order['orderID']);

        if ($this->paymentService->checkoutOrder($order['orderID'], $transaction)) {
            return new RedirectResponse('/payment/landing');
        }

        return new RedirectResponse('/payment/cancel');
    }
}
