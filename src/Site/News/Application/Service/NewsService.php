<?php

namespace App\Site\News\Application\Service;

use App\Site\News\Domain\Entity\News;
use App\Site\News\Domain\Repository\NewsRepositoryInterface;

class NewsService
{
    public function __construct(
        private readonly NewsRepositoryInterface $repository
    ) {
    }

    /**
     * @return News[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function save(News $news, bool $flush): void
    {
        $this->repository->save($news, $flush);
    }

    public function remove(News $news, bool $flush): void
    {
        $this->repository->remove($news, $flush);
    }
}
