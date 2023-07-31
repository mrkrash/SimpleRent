<?php

namespace App\Cart\Domain\Service;

interface PaymentServiceInterface
{
    public function createOrder(int $amount, int $refId, string $returnUrl, string $cancelUrl): array;
    public function checkoutOrder(string $orderId): bool;
    public function captureOrder(string $orderId, string $transactionId): bool;
}