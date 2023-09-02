<?php

namespace App\Controller;

use App\Booking\Application\Service\CartService;
use App\Product\Application\Service\ProductService;
use App\Product\Domain\Entity\Product;
use App\Shared\Enum\BicycleType;
use App\Site\Page\Domain\Entity\Page;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CartService $cartService, ProductService $productService): Response
    {
        $cart = $cartService->handle();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => [
                $productService->retrieveOneByType(BicycleType::MOUNTAINBIKE),
                $productService->retrieveOneByType(BicycleType::EBIKE),
                $productService->retrieveOneByType(BicycleType::GRAVEL),
                $productService->retrieveOneByType(BicycleType::RACINGBIKE),
            ],
            'dateStart' => $cart->getDateStart()?->format('Y-m-d'),
            'dateEnd' => $cart->getDateEnd()?->format('Y-m-d'),
            'cart' => $cart,
        ]);
    }

    #[Route('/tours', name: 'tours')]
    public function tours(): Response
    {
        return $this->render('coming.html.twig');
    }

    #[Route('/percorsi-cicloturistici', name: 'cycling_routes')]
    public function cyclingRoutes(): Response
    {
        return $this->render('coming.html.twig');
    }

    #[Route('/scooter', name: 'scooter')]
    public function scooter(): Response
    {
        return $this->render('coming.html.twig');
    }

    #[Route('/book/{id}', name: 'view_product', methods: ['GET'])]
    public function view(Product $product): Response
    {
        return $this->render('home/show.html.twig', [
            'controller_name' => 'HomeController',
            'product' => $product,
        ]);
    }
}
