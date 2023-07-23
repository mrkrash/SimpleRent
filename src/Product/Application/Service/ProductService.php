<?php declare(strict_types=1);

namespace App\Product\Application\Service;

use App\Product\Domain\Entity\Product;
use App\Product\Infrastructure\Repository\ProductRepository;

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
}