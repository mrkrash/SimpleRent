<?php

namespace App\Controller;

use App\Cart\Application\Service\CartService;
use App\Cart\Domain\Entity\CartItem;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/rest/addToCart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(
        Request        $request,
        CartService    $retrieveCartService,
    ): Response
    {
        $cart = $retrieveCartService->handle();

        $cart->setDateStart((new DateTimeImmutable())->setTimestamp($request->getPayload()->get('start') /1000));
        $cart->setDateEnd((new DateTimeImmutable())->setTimestamp($request->getPayload()->get('end') /1000));
        $cartItem = new CartItem();
        if ('product' === $request->getPayload()->get('type')) {
            $cartItem->setProductId($request->getPayload()->get('id'));
        } else {
            $cartItem->setAccessoryId($request->getPayload()->get('id'));
        }
        $cartItem->setSize($request->getPayload()->get('size'));
        $cartItem->setQty(1);
        $cart->addCartItem($cartItem);

        $retrieveCartService->save($cart);

        return new JsonResponse($cart);
    }
}
