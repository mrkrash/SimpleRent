<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function save(Product $entity, bool $flush = false): void;
    public function remove(Product $entity, bool $flush = false): void;
    public function findEnabled(): array;
}