<?php

namespace App\Product\Application\Controller;

use App\Booking\Application\Service\CartService;
use App\Product\Application\Service\ProductService;
use App\Shared\Enum\BicycleType;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly PageRepository $pageRepository,
        private readonly ProductService $service,
    ) {
    }

    #[Route('/bicycle/{type}', name: 'product_bycicle')]
    public function bicycle(string $type): Response
    {
        $cart = $this->cartService->handle();
        $products = $this->service->retrieveBicycleAvailableByType(BicycleType::tryFrom($type));
        if (empty($products)) {
            return $this->render('not-found.html.twig');
        }

        return $this->render('home/products.html.twig', [
            'title' => $type,
            'products' => $products,
            'book' => true,
            'dateStart' => $cart->getDateStart()?->format('Y-m-d'),
            'dateEnd' => $cart->getDateEnd()?->format('Y-m-d'),
            'cart' => $cart,
            'news_list' => $this->pageRepository->findAll(),
        ]);
    }

    #[Route('/accessories', name: 'product_accessories')]
    public function accessories(): Response
    {
        $cart = $this->cartService->handle();
        $products = $this->service->retrieveAccessoryDtoByType();
        if (empty($products)) {
            return $this->render('not-found.html.twig');
        }

        return $this->render('home/products.html.twig', [
            'title' => 'Accessori',
            'products' => $products,
            'book' => true,
            'dateStart' => $cart->getDateStart()?->format('Y-m-d'),
            'dateEnd' => $cart->getDateEnd()?->format('Y-m-d'),
            'cart' => $cart,
            'news_list' => $this->pageRepository->findAll(),
        ]);
    }
}
