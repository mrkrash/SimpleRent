<?php declare(strict_types=1);

namespace App\Product\Application\Service;

use App\Product\Domain\Entity\Product;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Shared\Enum\BicycleType;

final class ProductService
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function retrieveById(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    public function retrieveOneByType(BicycleType $type): ?Product
    {
        return $this->productRepository->findOneBy(['type' => $type]);
    }
}