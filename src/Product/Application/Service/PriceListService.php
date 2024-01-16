<?php

namespace App\Product\Application\Service;

use App\Product\Domain\Entity\PriceList;
use App\Product\Domain\Repository\PriceListRepositoryInterface;

final class PriceListService
{
    public function __construct(
        private readonly PriceListRepositoryInterface $repository
    ) {
    }

    /** @return PriceList[] */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
