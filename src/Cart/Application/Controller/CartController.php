<?php

namespace App\Cart\Application\Controller;

use App\Cart\Application\Service\CartService;
use App\Cart\Application\Service\RateService;
use App\Cart\Domain\Entity\CartItem;
use App\Entity\Dto\ProductDto;
use App\Product\Application\Service\ProductService;
use App\Product\Domain\Entity\Product;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
    )
    {
    }

    #[Route('/rest/addToCart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(
        Request        $request,
    ): Response
    {
        $cart = $this->cartService->handle();

        $cart->setDateStart((new DateTimeImmutable())->setTimestamp($request->getPayload()->get('start') /1000));
        $cart->setDateEnd((new DateTimeImmutable())->setTimestamp($request->getPayload()->get('end') /1000));
        $cartItem = $this->cartService->getItemFromCart($cart, $request->getPayload()->get('id'));
        if ('product' === $request->getPayload()->get('type')) {
            $cartItem->setProductId($request->getPayload()->get('id'));
        } else {
            $cartItem->setAccessoryId($request->getPayload()->get('id'));
        }
        $cartItem->setSize($request->getPayload()->get('size'));
        $cartItem->setQty(1);
        $cart->addCartItem($cartItem);

        $this->cartService->save($cart);

        return new JsonResponse($cart);
    }

    #[Route('/book', name: 'book_cart', methods: ['GET'])]
    public function book(
        ProductService $productService,
        RateService $rateService
    ): Response
    {
        $cart = $this->cartService->handle();
        $rate = 0;
        $products = [];
        $days = $cart->getDateEnd()->diff($cart->getDateStart())->days;
        /** @var CartItem $item */
        foreach ($cart->getCartItems() as $item) {
            $product = $productService->retrieveById($item->getProductId());
            $rate += $rateService->calc(
                $days,
                $product->getPriceList()->getPriceOneDay(),
                $product->getPriceList()->getPriceThreeDays(),
                $product->getPriceList()->getPriceSevenDays()
            );
            $products[] = new ProductDto(
                $product->getId(),
                $product->getName(),
                $item->getSize(),
                $product->getImage(),
                $item->getQty(),
                $rate
            );
        }

        return $this->render('home/book.html.twig', [
            'products' => $products,
            'start' => $cart->getDateStart(),
            'end' => $cart->getDateEnd(),
            'rate' => $rate
        ]);
    }
}
