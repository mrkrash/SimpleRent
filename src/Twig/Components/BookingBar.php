<?php

namespace App\Twig\Components;

use App\Booking\Application\Service\CartService;
use App\Booking\Domain\Entity\Cart;
use DateTimeInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class BookingBar
{
    public Cart $cart;
    public ?DateTimeInterface $dateStart;
    public ?DateTimeInterface $dateEnd;

    public function __construct(CartService $cartService)
    {
        $this->cart = $cartService->handle();
        $this->dateStart = $this->cart->getDateStart();
        $this->dateEnd = $this->cart->getDateEnd();
    }
}
