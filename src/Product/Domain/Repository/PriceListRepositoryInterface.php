<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\PriceList;

/**
 * @method PriceList|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceList|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceList[]    findAll()
 * @method PriceList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface PriceListRepositoryInterface
{
    public function remove(PriceList $entity, bool $flush = false): void;
    public function save(PriceList $entity, bool $flush = false): void;
}