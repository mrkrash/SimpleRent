<?php declare(strict_types=1);

namespace App\Cart\Application\Service;

use App\Cart\Domain\Entity\Cart;
use App\Cart\Domain\Entity\CartItem;
use App\Cart\Domain\Repository\CartItemRepositoryInterface;
use App\Cart\Domain\Repository\CartRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class CartService
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly CartItemRepositoryInterface $cartItemRepository,
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

    public function getItemFromCart(Cart $cart, int $productId): CartItem
    {
        if (null === $cart->getId()) {
            return new CartItem();
        }
        $cartItem = $this->cartItemRepository->getFromCart($cart, $productId);
        if (null === $cartItem) {
            $cartItem = new CartItem();
        }

        return $cartItem;
    }

    public function save(Cart $cart): void
    {
        $this->cartRepository->save($cart, true);
        $this->requestStack->getSession()->set('cart', $cart);
    }
}