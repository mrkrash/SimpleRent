<?php

namespace App\Booking\Application\Service;

use App\Booking\Domain\Entity\Booking;
use App\Booking\Domain\Repository\BookingRepositoryInterface;
use App\Customer\Domain\Entity\Customer;
use DateTimeImmutable;

class BookingService
{
    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository
    ) {
    }

    public function save(
        Customer $customer,
        DateTimeImmutable $start,
        DateTimeImmutable $end,
        array $items,
        int $rate
    ): Booking
    {
        $booking = (new Booking())
            ->setCustomer($customer)
            ->setDateStart($start)
            ->setDateEnd($end)
            ->setProducts($items)
            ->setRate($rate)
        ;
        $this->bookingRepository->save($booking, true);

        return $booking;
    }
}