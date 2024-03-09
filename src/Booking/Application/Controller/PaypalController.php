<?php

namespace App\Booking\Application\Controller;

use App\Booking\Application\Service\BookingService;
use App\Booking\Application\Service\CartService;
use App\Booking\Application\Service\TransactionService;
use App\Booking\Domain\Service\PaymentServiceInterface;
use App\Customer\Application\Service\CustomerService;
use App\Shared\DTO\CustomerDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[Route('/paypal')]
class PaypalController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
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
        CustomerService $customerService,
    ): Response {
        $cart = $this->cartService->handle();
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
            $cart->getCartItems(),
            $cart->getRate()
        );

        $order = $this->paymentService->createOrder(
            $cart->getRate(),
            $booking->getId(),
            'https://' . $request->server->get('HTTP_HOST') . $this->generateUrl('payment_landing'),
            'https://' . $request->server->get('HTTP_HOST') . $this->generateUrl('payment_cancel'),
        );

        $transaction = $this->transactionService->save(
            $order['id'],
            $order['status'],
            $order,
            'paypal',
            $cart->getRate(),
            0,
            $booking
        );
        $booking->setTransaction($transaction);
        $bookingService->update($booking);

        return new JsonResponse($order);
    }

    #[Route('/capture', name: 'paypal-capture', methods: ['POST'])]
    public function capture(
        Request $request,
    ) {
        $order = $request->getPayload()->all()['order'];
        $transaction = $this->transactionService->retrieveByTransportId($order['orderID']);

        if (null !== $transaction && $this->paymentService->checkoutOrder($order['orderID'], $transaction)) {
            try {
                $this->transactionService->notifyPeers($transaction);
            } catch (TransportExceptionInterface $e) {
            }
            $cart = $this->cartService->handle();
            $this->cartService->remove($cart);
            return new RedirectResponse('/payment/landing');
        }

        return new RedirectResponse('/payment/cancel');
    }
}
