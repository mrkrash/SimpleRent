<?php

declare(strict_types=1);

namespace App\Product\Application\Service;

use App\Product\Domain\Entity\Product;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Shared\DTO\ProductDto;
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
        return $this->productRepository->findOneBy(['bicycleType' => $type]);
    }

    /**
     * @return Product[]
     */
    public function retrieveByType(BicycleType $type): array
    {
        return $this->productRepository->findBy(['bicycleType' => $type]);
    }

    /**
     * @return ProductDto[]
     */
    public function retrieveDtoByType(BicycleType $type): array
    {
        $products = [];
        foreach ($this->retrieveByType($type) as $product) {
            $products[] = new ProductDto($product->getId(), $product->getName(), $product->getImage(), 'S', 1);
        }

        return $products;
    }
}
