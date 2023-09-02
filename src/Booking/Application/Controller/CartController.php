<?php

namespace App\Booking\Application\Controller;

use App\Booking\Application\Service\CartService;
use App\Booking\Application\Service\RateService;
use App\Booking\Domain\Entity\CartItem;
use App\Product\Application\Service\ProductService;
use App\Shared\DTO\ProductDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $cartItems = [];
        /** @var CartItem $item */
        foreach ($cart->getCartItems() as $item) {
            $product = $productService->retrieveById($item->getProductId());
            $cartItems[] = [
                'id' => $item->getId(),
                'product' => new ProductDto(
                    idx: $product->getId(),
                    name: $product->getName(),
                    image: $product->getImage(),
                    size: $productService->retrieveSizeHumanReadable($item->getSize()),
                    qty: $item->getQty()
                )
            ];
        }

        return $this->render('home/cart.html.twig', [
            'items' => $cartItems,
            'cart' => $cart,
        ]);
    }

    #[Route('/addToCart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(
        Request $request,
        RateService $rateService
    ): Response {
        $cart = $this->cartService->handle();
        $cartItem = $this->cartService->getItemFromCart(
            $cart,
            $request->getPayload()->get('id'),
            $request->getPayload()->get('size')
        );
        $cartItem->setProductId($request->getPayload()->get('id'));
        $cartItem->setSize($request->getPayload()->get('size'));
        $cartItem->setQty($cartItem->getQty() + 1);
        $cart->addCartItem($cartItem);
        $cart->setRate($this->cartService->rate($cart));
        $this->cartService->save($cart);

        return new JsonResponse($cart);
    }

    #[Route('/deleteFromCart/{id}', name: 'delete_item', methods: ['DELETE'])]
    public function deleteFromCart(CartItem $item): Response
    {
        $cart = $this->cartService->handle();
        if ($cart->removeCartItem($item)) {
            $cart->setRate($this->cartService->rate($cart));
            $this->cartService->save($cart);
            return new JsonResponse(['success' => true, 'cart' => $cart]);
        }

        return new Response('Item not Found', 404);
    }
}
