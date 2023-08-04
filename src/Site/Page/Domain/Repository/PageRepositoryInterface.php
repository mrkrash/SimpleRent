<?php

namespace App\Site\Page\Domain\Repository;

use App\Site\Page\Domain\Entity\Page;

interface PageRepositoryInterface
{
    public function save(Page $entity, bool $flush = false): void;
    public function remove(Page $entity, bool $flush = false): void;
}