<?php

namespace App\Cart\Application\Controller;

use App\Booking\Application\Service\BookingService;
use App\Booking\Domain\Entity\Booking;
use App\Booking\Infrastructure\Repository\BookingRepository;
use App\Cart\Application\Service\CartService;
use App\Cart\Application\Service\TransactionService;
use App\Cart\Domain\Entity\Transaction;
use App\Cart\Domain\Service\PaymentServiceInterface;
use App\Cart\Infrastructure\Repository\TransactionRepository;
use App\Customer\Application\Service\CustomerService;
use App\Shared\DTO\CustomerDto;
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
        private readonly PaymentServiceInterface $paymentService,
        private readonly TransactionService $transactionService,
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
        BookingService $bookingService,
        CartService $cartService,
        CustomerService $customerService,
    ): Response {
        $cart = $cartService->handle();
        $customer = $request->getPayload()->all()['customer'];

        $customer = $customerService->handle(new CustomerDto(
            $customer['firstname'],
            $customer['lastname'],
            $customer['phone'],
            $customer['email'],
            $customer['privacy'],
            $customer['newsletter'],
        ));

        $booking = $bookingService->save(
            $customer,
            $cart->getDateStart(),
            $cart->getDateEnd(),
            $cart->getCartItems()->toArray(),
            $cart->getRate()
        );

        $order = $this->paymentService->createOrder(
            $cart->getRate(),
            $booking->getId(),
            $request->server->get('HTTP_HOST') . $this->generateUrl('paypal_landing'),
            $request->server->get('HTTP_HOST') . $this->generateUrl('paypal_cancel'),
        );

        $this->transactionService->save(
            $order['id'],
            $order['status'],
            $order,
            'paypal',
            $cart->getRate(),
            0,
            $booking
        );

        return new JsonResponse($order);
    }

    #[Route('/capture', name: 'paypal-capture', methods: ['POST'])]
    public function capture(
        Request $request,
    ) {
        $order = $request->getPayload()->all()['order'];
        $transaction = $this->transactionService->retrieveByTransportId($order['orderID']);

        if (null !== $transaction && $this->paymentService->checkoutOrder($order['orderID'], $transaction)) {
            return new RedirectResponse('/payment/landing');
        }

        return new RedirectResponse('/payment/cancel');
    }
}
