<?php

namespace App\Controller;

use App\Cart\Application\Service\RateService;
use App\Entity\Booking;
use App\Entity\Dto\ProductDto;
use App\Product\Domain\Entity\Product;
use App\Repository\BookingRepository;
use App\Repository\CustomerRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rest')]
class RestController extends AbstractController
{
    /**
     * Actually generate a booking for test
     * @param CustomerRepository $customerRepository
     * @param BookingRepository $bookingRepository
     * @return void
     */
    #[Route('/generate')]
    public function generateRandomValue(
        CustomerRepository $customerRepository,
        BookingRepository $bookingRepository,
    ): void {
        $booking = (new Booking())
            ->setCustomer($customerRepository->find(1))
            ->setDateStart(new DateTimeImmutable('20230712T000000'))
            ->setDateEnd(new DateTimeImmutable('20230718T000000'))
        ;
        $booking->addProduct(new ProductDto(1, 'S', 1));
        $booking->addProduct(new ProductDto(2, 'S', 1));
        $bookingRepository->save($booking, true);
    }

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