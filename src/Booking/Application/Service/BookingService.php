<?php

namespace App\Booking\Application\Service;

use App\Booking\Domain\Entity\BookedProduct;
use App\Booking\Domain\Entity\Booking;
use App\Booking\Domain\Entity\CartItem;
use App\Booking\Domain\Repository\BookingRepositoryInterface;
use App\Customer\Domain\Entity\Customer;
use App\Product\Application\Service\ProductService;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class BookingService
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository,
        private readonly ProductService $productService,
    ) {
    }

    public function save(
        Customer $customer,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        Collection $items,
        int $rate
    ): Booking {
        $booking = (new Booking())
            ->setCustomer($customer)
            ->setDateStart($start)
            ->setDateEnd($end)
            ->setRate($rate)
        ;
        /** @var CartItem $item */
        foreach ($items as $item) {
            $product = $this->productService->retrieveById($item->getProductId());
            $booking->addProduct((new BookedProduct())
                ->setProduct($product)
                ->setBooking($booking)
                ->setQty($item->getQty())
                ->setSize($item->getSize()));
        }
        $this->bookingRepository->save($booking, true);

        return $booking;
    }

    public function update(Booking $booking): Booking
    {
        $this->bookingRepository->save($booking, true);
        return $booking;
    }
}
