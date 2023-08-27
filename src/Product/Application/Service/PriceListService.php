<?php

namespace App\Product\Application\Service;

use App\Product\Domain\Repository\PriceListRepositoryInterface;

final class PriceListService
{
    public function __construct(
        private readonly PriceListRepositoryInterface $repository
    ) {
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}
