<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Product;
use App\Shared\DTO\ProductDto;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\ProductType;

interface ProductRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function save(Product $entity, bool $flush = false): void;
    public function remove(Product $entity, bool $flush = false): void;
    public function findEnabled(): array;

    /**
     * @return ProductDto[]
     */
    public function findAllSizeWithQtyByType(ProductType $type, ?BicycleType $bicycleType = null): array;
}
