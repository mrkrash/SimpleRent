<?php

declare(strict_types=1);

namespace App\Booking\Application\Service;

use App\Booking\Domain\Entity\Cart;
use App\Booking\Domain\Entity\CartItem;
use App\Booking\Domain\Repository\CartItemRepositoryInterface;
use App\Booking\Domain\Repository\CartRepositoryInterface;
use App\Product\Application\Service\ProductService;
use Symfony\Component\HttpFoundation\RequestStack;

final class CartService
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly CartItemRepositoryInterface $cartItemRepository,
        private readonly ProductService $productService,
        private readonly RateService $rateService,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function handle(): Cart
    {
        $session = $this->requestStack->getSession();
        /** @var Cart $cart */
        $cart = $session->get('cart', new Cart());

        if (null !== $cart->getId()) {
            /** @var ?Cart $cartFromDb */
            $cartFromDb = $this->cartRepository->find($cart->getId());
            if (null === $cartFromDb) {
                $session->remove('cart');
                $cart = new Cart();
            } else {
                $cart = $cartFromDb;
            }
        }

        return $cart;
    }

    public function getItemFromCart(Cart $cart, int $productId, int $productQtyId): CartItem
    {
        if (null === $cart->getId()) {
            return new CartItem();
        }
        $cartItem = $this->cartItemRepository->getFromCart($cart, $productId, $productQtyId);
        if (null === $cartItem) {
            $cartItem = new CartItem();
        }

        return $cartItem;
    }

    public function rate(Cart $cart): int
    {
        $rate = 0;
        $days = $cart->getDateEnd()->diff($cart->getDateStart())->days;
        foreach ($cart->getCartItems() as $item) {
            $product = $this->productService->retrieveById($item->getProductId());
            $rate += ($this->rateService->calc(
                $days,
                $product->getPriceList()->getPriceOneDay(),
                $product->getPriceList()->getPriceThreeDays(),
                $product->getPriceList()->getPriceSevenDays()
            ) * $item->getQty());
        }

        return (int) $rate;
    }

    public function save(Cart $cart): void
    {
        $this->cartRepository->save($cart, true);
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function remove(Cart $cart): void
    {
        $this->cartRepository->remove($cart, true);
        $this->requestStack->getSession()->remove('cart');
    }
}
