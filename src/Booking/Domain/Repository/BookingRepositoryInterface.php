<?php

namespace App\Booking\Domain\Repository;

use App\Booking\Domain\Entity\Booking;
use DateTimeImmutable;

interface BookingRepositoryInterface
{
    public function save(Booking $entity, bool $flush = false): void;
    public function remove(Booking $entity, bool $flush = false): void;
    public function checkDates(DateTimeImmutable $start, DateTimeImmutable $stop): array;
}