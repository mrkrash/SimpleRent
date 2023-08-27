<?php

namespace App\Booking\Domain\Repository;

use App\Booking\Domain\Entity\Cart;
use App\Booking\Domain\Entity\CartItem;

interface CartItemRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function getFromCart(Cart $cart, int $productId): ?CartItem;
    public function save(CartItem $entity, bool $flush = false): void;
    public function remove(CartItem $entity, bool $flush = false): void;
}
