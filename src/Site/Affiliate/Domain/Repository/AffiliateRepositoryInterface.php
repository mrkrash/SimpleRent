<?php

namespace App\Site\Affiliate\Domain\Repository;

use App\Site\Affiliate\Domain\Entity\Affiliate;

interface AffiliateRepositoryInterface
{
    public function save(Affiliate $entity, bool $flush = false): void;
    public function remove(Affiliate $entity, bool $flush = false): void;
}