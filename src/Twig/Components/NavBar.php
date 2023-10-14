<?php

namespace App\Twig\Components;

use App\Site\Page\Domain\Entity\Page;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

 #[AsTwigComponent]
class NavBar
{
    public array $newsList;
    public function __construct(
        PageRepository $pageRepository,
    ) {
        $this->newsList = $pageRepository->findBy(['type' => Page::NEWS]);
    }
}