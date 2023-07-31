<?php

namespace App\Cart\Domain\Repository;

use App\Cart\Domain\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function save(Transaction $entity, bool $flush = false): void;
    public function remove(Transaction $entity, bool $flush = false): void;
    public function findOneByTransportId(string $transportId): ?Transaction;
}