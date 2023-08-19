<?php

namespace App\Booking\Application\Controller;

use App\Booking\Application\Service\CartService;
use App\Booking\Application\Service\RateService;
use App\Product\Application\Service\ProductService;
use App\Shared\Enum\BicycleType;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class InteractionController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly ProductService $productService,
    ) {
    }

    #[Route('/start/{dateStart}/end/{dateEnd}', name: 'book_select_product', methods: ['GET'])]
    public function selectProducts(
        DateTimeImmutable $dateStart,
        DateTimeImmutable $dateEnd,
    ): Response {
        $cart = $this->cartService->handle();
        $cart->setDateStart($dateStart)->setDateEnd($dateEnd);

        return $this->render('home/book.html.twig', [
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd,
            'products' => [
                'mountainbike' => $this->productService->retrieveBicycleDtoByType(BicycleType::MOUNTAINBIKE),
                'ebike' => $this->productService->retrieveBicycleDtoByType(BicycleType::EBIKE),
                'gravel' => $this->productService->retrieveBicycleDtoByType(BicycleType::GRAVEL),
                'racing' => $this->productService->retrieveBicycleDtoByType(BicycleType::RACINGBIKE),
            ],
        ]);
    }

    #[Route('/addToCart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(
        Request $request,
        RateService $rateService
    ): Response {
        $cart = $this->cartService->handle();

        $cart->setDateStart((new DateTimeImmutable())->setTimestamp($request->getPayload()->get('start') / 1000));
        $cart->setDateEnd((new DateTimeImmutable())->setTimestamp($request->getPayload()->get('end') / 1000));
        $cartItem = $this->cartService->getItemFromCart($cart, $request->getPayload()->get('id'));
        if ('product' === $request->getPayload()->get('type')) {
            $cartItem->setProductId($request->getPayload()->get('id'));
        } else {
            $cartItem->setAccessoryId($request->getPayload()->get('id'));
        }
        $cartItem->setSize($request->getPayload()->get('size'));
        $cartItem->setQty($cartItem->getQty() + 1);
        $cart->addCartItem($cartItem);

        $rate = 0;
        $days = $cart->getDateEnd()->diff($cart->getDateStart())->days;
        foreach ($cart->getCartItems() as $item) {
            $product = $this->productService->retrieveById($item->getProductId());
            $rate += ($rateService->calc(
                $days,
                $product->getPriceList()->getPriceOneDay(),
                $product->getPriceList()->getPriceThreeDays(),
                $product->getPriceList()->getPriceSevenDays()
            ) * $item->getQty());
        }
        $cart->setRate($rate);

        $this->cartService->save($cart);

        return new JsonResponse($cart);
    }
}
