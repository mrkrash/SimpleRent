<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Shared\Enum\ProductSize;

/**
 * @method ProductQty|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductQty|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductQty[]    findAll()
 * @method ProductQty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ProductQtyRepositoryInterface
{
    public function save(ProductQty $entity, bool $flush = false): void;
    public function remove(ProductQty $entity, bool $flush = false): void;
    public function getBySize(Product $product, ProductSize $size): ?ProductQty;
}