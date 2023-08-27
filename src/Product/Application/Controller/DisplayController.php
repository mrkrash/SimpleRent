<?php

namespace App\Product\Application\Controller;

use App\Product\Application\Service\ProductService;
use App\Shared\Enum\BicycleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends AbstractController
{
    public function __construct(
        private readonly ProductService $service,
    ) {
    }

    #[Route('/bicycle/{type}', name: 'product_bycicle')]
    public function bicycle(string $type): Response
    {
        $products = $this->service->retrieveBicycleDtoByType(BicycleType::tryFrom($type));
        if (empty($products)) {
            return $this->render('not-found.html.twig');
        }

        return $this->render('home/products.html.twig', [
            'title' => $type,
            'products' => $products,
            'book' => false,
        ]);
    }
}
