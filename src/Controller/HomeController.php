<?php

namespace App\Controller;

use App\Entity\Page;
use App\Product\Application\Service\ProductService;
use App\Product\Domain\Entity\Product;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Repository\PageRepository;
use App\Shared\Enum\BicycleType;
use App\Site\Affiliate\Infrastructure\Repository\AffiliateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductService $productService): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => [
                $productService->retrieveOneByType(BicycleType::MOUNTAINBIKE),
                $productService->retrieveOneByType(BicycleType::EBIKE),
                $productService->retrieveOneByType(BicycleType::GRAVEL),
                $productService->retrieveOneByType(BicycleType::RACINGBIKE),
            ],
        ]);
    }

    #[Route('/chi-siamo', name: 'who_are')]
    public function whoAre(): Response
    {
        return $this->render('coming.html.twig');
    }

    #[Route('/tours', name: 'tours')]
    public function tours(): Response
    {
        return $this->render('coming.html.twig');
    }



    #[Route('/ragusa-ibla', name: 'ragusa_ibla')]
    public function ragusaIbla(PageRepository $pageRepository): Response
    {
        /** @var Page $page */
        $page = $pageRepository->findOneBy(['slug' => 'ragusa_ibla']);
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }

    #[Route('/percorsi-cicloturistici', name: 'cycling_routes')]
    public function cyclingRoutes(): Response
    {
        return $this->render('coming.html.twig');
    }

    #[Route('/terms', name: 'terms')]
    public function terms(PageRepository $pageRepository): Response
    {
        /** @var Page $page */
        $page = $pageRepository->findOneBy(['slug' => 'terms']);
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }

    #[Route('/accept-privacy', name: 'accept_privacy')]
    public function acceptPrivacy(PageRepository $pageRepository): Response
    {
        /** @var Page $page */
        $page = $pageRepository->findOneBy(['slug' => 'accept_privacy']);
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }

    #[Route('/privacy', name: 'privacy')]
    public function privacy(PageRepository $pageRepository): Response
    {
        /** @var Page $page */
        $page = $pageRepository->findOneBy(['slug' => 'privacy']);
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }

    #[Route('/cookies_policy', name: 'cookies_policy')]
    public function cookie(PageRepository $pageRepository): Response
    {
        /** @var Page $page */
        $page = $pageRepository->findOneBy(['slug' => 'cookie_policy']);
        return $this->render('home/generic.html.twig', [
            'title' => $page->getTitle(),
            'content' => $page->getContent(),
        ]);
    }

    #[Route('/bicycle/{type}', name: 'product_bycicle')]
    public function bicycle(string $type, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy(['bicycleType' => $type, 'enabled' => true]);
        if (null === $products) {
            return $this->render('not-found.html.twig');
        }

        return $this->render('home/products.html.twig', [
            'title' => $type,
            'products' => $productRepository->findBy(['bicycleType' => $type])
        ]);
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
