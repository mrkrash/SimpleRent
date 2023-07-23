<?php

namespace App\Cart\Domain\Repository;

use App\Cart\Domain\Entity\CartItem;

interface CartItemRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function save(CartItem $entity, bool $flush = false): void;
    public function remove(CartItem $entity, bool $flush = false): void;
}