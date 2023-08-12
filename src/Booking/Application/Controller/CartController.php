<?php

namespace App\Booking\Application\Controller;

use App\Booking\Application\Service\CartService;
use App\Booking\Domain\Entity\CartItem;
use App\Entity\Dto\ProductDto;
use App\Product\Application\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
    ) {
    }



    #[Route('/book', name: 'book_cart', methods: ['GET'])]
    public function book(
        ProductService $productService,
    ): Response {
        $cart = $this->cartService->handle();
        $products = [];
        /** @var CartItem $item */
        foreach ($cart->getCartItems() as $item) {
            $product = $productService->retrieveById($item->getProductId());
            $products[] = new ProductDto(
                $product->getId(),
                $product->getName(),
                $item->getSize(),
                $product->getImage(),
                $item->getQty()
            );
        }

        return $this->render('home/book.html.twig', [
            'products' => $products,
            'start' => $cart->getDateStart(),
            'end' => $cart->getDateEnd(),
            'rate' => $cart->getRate(),
        ]);
    }
}
