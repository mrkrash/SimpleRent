<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\PriceList;

interface PriceListRepositoryInterface
{
    /**
     * @return PriceList[]
     */
    public function findAll();
}