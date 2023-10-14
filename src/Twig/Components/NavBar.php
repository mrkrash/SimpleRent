<?php

namespace App\Twig\Components;

use App\Booking\Application\Service\CartService;
use App\Booking\Domain\Entity\Cart;
use App\Site\Page\Domain\Entity\Page;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class NavBar
{
    public Cart $cart;
    public array $newsList;
    public function __construct(
        CartService $cartService,
        PageRepository $pageRepository,
    ) {
        $this->cart = $cartService->handle();
        $this->newsList = $pageRepository->findBy(['type' => Page::NEWS]);
    }
}