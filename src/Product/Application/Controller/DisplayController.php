<?php

namespace App\Product\Application\Controller;

use App\Product\Application\Service\ProductService;
use App\Shared\Enum\BicycleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    private bool $isBooking;
    public function __construct(
        private readonly ProductService $service,
        RequestStack $requestStack,
    ) {
        $this->isBooking = $requestStack->getSession()->has('cart');
    }

    #[Route('/bicycle/{type}', name: 'product_bycicle')]
    public function bicycle(string $type): Response
    {
        $products = $this->service->retrieveBicycleAvailableByType(BicycleType::tryFrom($type));
        if (empty($products)) {
            return $this->render('not-found.html.twig');
        }

        return $this->render('home/products.html.twig', [
            'title' => $type,
            'products' => $products,
            'book' => $this->isBooking,
        ]);
    }

    #[Route('/accessories', name: 'product_accessories')]
    public function accessories(): Response
    {
        $products = $this->service->retrieveAccessoryDtoByType();
        if (empty($products)) {
            return $this->render('not-found.html.twig');
        }

        return $this->render('home/products.html.twig', [
            'title' => 'Accessori',
            'products' => $products,
            'book' => $this->isBooking,
        ]);
    }
}
