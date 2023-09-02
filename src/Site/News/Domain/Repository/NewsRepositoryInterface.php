<?php

namespace App\Site\News\Domain\Repository;

use App\Site\News\Domain\Entity\News;

interface NewsRepositoryInterface
{
    /** @return News[] */
    public function findAll(): array;
    public function findOne(int $idx): ?News;
    public function save(News $entity, bool $flush = false): void;
    public function remove(News $entity, bool $flush = false): void;
}
