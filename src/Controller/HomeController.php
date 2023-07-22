<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Dto\ProductDto;
use App\Entity\Product;
use App\Entity\Transaction;
use App\Repository\AccessoryRepository;
use App\Repository\BookingRepository;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Repository\TransactionRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $productRepository->findEnabled(),
        ]);
    }

    #[Route('/book/{id}', name: 'view_product', methods: ['GET'])]
    public function view(Product $product): Response
    {
        return $this->render('home/show.html.twig', [
            'controller_name' => 'HomeController',
            'product' => $product,
        ]);
    }
    #[Route('/book', name: 'book_product', methods: ['POST'])]
    public function book(
        Request $request,
        ProductRepository $productRepository,
        AccessoryRepository $accessoryRepository,
    ): Response
    {
        $product = $productRepository->find($request->getPayload()->get('id'));
        $size = $request->getPayload()->get('size');
        $start = (new DateTimeImmutable())->setTimestamp($request->getPayload()->get('start') /1000);
        $end = (new DateTimeImmutable())->setTimestamp($request->getPayload()->get('end') /1000);
        $rate = $this->getRate(
            $end->diff($start)->days,
            $product->getPriceList()->getPriceOneDay(),
            $product->getPriceList()->getPriceThreeDays(),
            $product->getPriceList()->getPriceSevenDays()
        );
        $productDto = new ProductDto($product->getId(), $product->getName(), $size, $product->getImage(), 1, $rate);
        $request->getSession()->set('products', [$productDto]);
        $request->getSession()->set('rate', $rate);
        $request->getSession()->set('start', $start);
        $request->getSession()->set('end', $end);

        return $this->render('home/book.html.twig', [
            'products' => [$productDto],
            'products_for_paypal' => json_encode([$productDto->forPaypal()]),
            'start' => $start,
            'end' => $end,
            'rate' => $rate
        ]);
    }

    /**
     * Actually generate a booking for test
     * @param CustomerRepository $customerRepository
     * @param BookingRepository $bookingRepository
     * @return void
     */
    #[Route('/rest/generate')]
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
    #[Route('/rest/booked/{id}/{size}/{start}/{end}')]
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
     * @return Response
     */
    #[Route('/rest/calc/{id}/{start}/{end}')]
    public function calc(
        Product $product,
        int $start,
        int $end
    ) : Response {
        $startDate = (new DateTimeImmutable())->setTimestamp($start/1000);
        $endDate = (new DateTimeImmutable())->setTimestamp($end/1000);
        $days = $endDate->diff($startDate)->days;
        return new JsonResponse(['rate' => $this->getRate(
            $days,
            $product->getPriceList()->getPriceOneDay(),
            $product->getPriceList()->getPriceThreeDays(),
            $product->getPriceList()->getPriceSevenDays()
        )]);
    }

    private function getRate(int $days, int $atOne, int $atThree, int $atSeven): float
    {
        $tot = 0;
        while ($days > 0) {
            if ($days >= 7) {
                $tot += $atSeven;
                $days -= 7;
                continue;
            }
            if ($days >= 3) {
                $tot += $atThree;
                $days -= 3;
                continue;
            }
            if ($days >= 1) {
                $tot += $atOne;
                $days -= 1;
            }
        }
        return $tot/100;
    }
}
