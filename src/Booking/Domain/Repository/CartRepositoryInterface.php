<?php

namespace App\Booking\Domain\Repository;

use App\Booking\Domain\Entity\Cart;

interface CartRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function save(Cart $entity, bool $flush = false): void;
    public function remove(Cart $entity, bool $flush = false): void;
}
