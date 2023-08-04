<?php

namespace App\Site\Page\Domain\Repository;

use App\Site\Page\Domain\Entity\Slide;

interface SlideRepositoryInterface
{
    public function save(Slide $entity, bool $flush = false): void;
    public function remove(Slide $entity, bool $flush = false): void;
}