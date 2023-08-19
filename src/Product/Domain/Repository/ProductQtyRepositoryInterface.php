<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Shared\Enum\ProductSize;

interface ProductQtyRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);

    /**
     * @return ProductQty[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    public function save(ProductQty $entity, bool $flush = false): void;
    public function remove(ProductQty $entity, bool $flush = false): void;
    public function getBySize(Product $product, ProductSize $size): ?ProductQty;
}