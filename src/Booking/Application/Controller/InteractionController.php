<?php

namespace App\Booking\Application\Controller;

use App\Booking\Application\Service\CartService;
use App\Booking\Application\Service\RateService;
use App\Product\Application\Service\ProductService;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\ProductType;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class InteractionController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly ProductService $productService,
    ) {
    }

    #[Route('/start/{dateStart}/end/{dateEnd}', name: 'book_select_product', methods: ['GET'])]
    public function selectProducts(
        DateTimeImmutable $dateStart,
        DateTimeImmutable $dateEnd,
    ): Response {
        $cart = $this->cartService->handle();
        $cart->setDateStart($dateStart)->setDateEnd($dateEnd);
        $this->cartService->save($cart);

        return $this->render('home/book.html.twig', [
            'cart' => $cart,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'products' => [
                'mountainbike' => $this->productService->retrieveBicycleAvailableByType(BicycleType::MOUNTAINBIKE),
                'ebike' => $this->productService->retrieveBicycleAvailableByType(BicycleType::EBIKE),
                'gravel' => $this->productService->retrieveBicycleAvailableByType(BicycleType::GRAVEL),
                'racing' => $this->productService->retrieveBicycleAvailableByType(BicycleType::RACINGBIKE),
            ],
        ]);
    }

    #[Route('accessory', name: 'book_select_accessory', methods: ['GET'])]
    public function selectAccessory(): Response
    {
        $cart = $this->cartService->handle();

        return $this->render('home/accessories.html.twig', [
            'cart' => $cart,
            'dateStart' => $cart->getDateStart(),
            'dateEnd' => $cart->getDateEnd(),
            'accessories' => $this->productService->retrieveAccessoryDtoByType(),
        ]);
    }
}
