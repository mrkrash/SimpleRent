<?php

namespace App\Booking\Application\Controller;

use App\Booking\Application\Service\CartService;
use App\Booking\Domain\Entity\CartItem;
use App\Product\Application\Service\ProductService;
use App\Shared\DTO\ProductDto;
use App\Shared\Enum\ProductSize;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
    ) {
    }

    #[Route('/', name: 'cart', methods: ['GET'])]
    public function book(
        ProductService $productService,
    ): Response {
        $cart = $this->cartService->handle();
        $products = [];
        /** @var CartItem $item */
        foreach ($cart->getCartItems() as $item) {
            $product = $productService->retrieveById($item->getProductId());
            $products[] = new ProductDto(
                idx: $product->getId(),
                name: $product->getName(),
                image: $product->getImage(),
                size: ProductSize::tryFrom($item->getSize()),
                qty: $item->getQty()
            );
        }

        return $this->render('home/cart.html.twig', [
            'products' => $products,
            'cart' => $cart,
        ]);
    }
}
