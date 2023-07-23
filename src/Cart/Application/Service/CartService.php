<?php declare(strict_types=1);

namespace App\Cart\Application\Service;

use App\Cart\Domain\Entity\Cart;
use App\Cart\Domain\Repository\CartRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class CartService
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly RequestStack $requestStack,
    )
    {
    }

    public function handle(): Cart
    {
        $this->requestStack->getSession()->clear();
        /** @var Cart $cart */
        $cart = $this->requestStack->getSession()->get('cart', new Cart());

        if (null !== $cart->getId()) {
            /** @var ?Cart $cartFromDb */
            $cartFromDb = $this->cartRepository->find($cart->getId());
            if (null !== $cartFromDb) {
                $this->cartRepository->remove($cartFromDb);
            }
            $cart = new Cart();
        }

        return $cart;
    }

    public function save(Cart $cart): void
    {
        $this->cartRepository->save($cart, true);
        $this->requestStack->getSession()->set('cart', $cart);
    }
}