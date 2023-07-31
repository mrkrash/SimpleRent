<?php

namespace App\Controller;

use App\Booking\Infrastructure\Repository\BookingRepository;
use App\Cart\Application\Service\RateService;
use App\Product\Domain\Entity\Product;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rest')]
class RestController extends AbstractController
{
    /**
     * Check Availability of selected product
     * @param Product $product
     * @param string $size
     * @param int $start
     * @param int $end
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    #[Route('/booked/{id}/{size}/{start}/{end}')]
    public function booked(
        Product $product,
        string $size,
        int $start,
        int $end,
        BookingRepository $bookingRepository
    ): Response
    {
        $startDate = (new DateTimeImmutable())->setTimestamp($start/1000);
        $endDate = (new DateTimeImmutable())->setTimestamp($end/1000);
        $dates = [];
        $product->populateQty();
        foreach ($bookingRepository->checkDates($startDate, $endDate) as $booking) {
            $products = $booking->getProducts();
            foreach ($products as $_product) {
                if (
                    $_product['id'] == $product->getId() &&
                    $_product['size'] == $size &&
                    $_product['qty'] == $product->{'getSize'.$size}()
                ) {
                    $dates[] = [
                        'title' => 'Non Disponibile',
                        'start' => $booking->getDateStart()->format(DATE_ATOM),
                        'end' => $booking->getDateEnd()->format(DATE_ATOM)
                    ];
                }
            }
        }

        return new JsonResponse($dates);
    }

    /**
     * Calculate rate for this product
     * @param Product $product
     * @param int $start
     * @param int $end
     * @param RateService $rateService
     * @return Response
     */
    #[Route('/calc/{id}/{start}/{end}')]
    public function calc(
        Product $product,
        int $start,
        int $end,
        RateService $rateService
    ) : Response {
        $startDate = (new DateTimeImmutable())->setTimestamp($start/1000);
        $endDate = (new DateTimeImmutable())->setTimestamp($end/1000);
        $days = $endDate->diff($startDate)->days;
        return new JsonResponse(['rate' => $rateService->calc(
            $days,
            $product->getPriceList()->getPriceOneDay(),
            $product->getPriceList()->getPriceThreeDays(),
            $product->getPriceList()->getPriceSevenDays()
        )]);
    }
}