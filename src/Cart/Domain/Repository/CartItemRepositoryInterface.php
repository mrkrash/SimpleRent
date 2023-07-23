<?php

namespace App\Cart\Domain\Repository;

use App\Cart\Domain\Entity\Cart;
use App\Cart\Domain\Entity\CartItem;

interface CartItemRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function getFromCart(Cart $cart, int $productId): ?CartItem;
    public function save(CartItem $entity, bool $flush = false): void;
    public function remove(CartItem $entity, bool $flush = false): void;
}