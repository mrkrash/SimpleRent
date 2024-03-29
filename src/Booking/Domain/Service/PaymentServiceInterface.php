<?php

namespace App\Booking\Domain\Service;

use App\Booking\Domain\Entity\Transaction;

interface PaymentServiceInterface
{
    public function createOrder(int $amount, int $refId, string $returnUrl, string $cancelUrl): array;
    public function checkoutOrder(string $orderId, Transaction $transaction): bool;
    public function capturePayment(string $orderId, Transaction $transaction): bool;
}
