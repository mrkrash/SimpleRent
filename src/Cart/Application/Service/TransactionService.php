<?php

namespace App\Cart\Application\Service;

use App\Booking\Domain\Entity\Booking;
use App\Cart\Domain\Entity\Transaction;
use App\Cart\Domain\Repository\TransactionRepositoryInterface;

class TransactionService
{
    public function __construct(
        private readonly TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function save(
        string $transportId,
        string $status,
        array $order,
        string $transport,
        int $amount,
        int $levied,
        Booking $booking
    ): Transaction {
        $transaction = (new Transaction())
            ->setTransportId($transportId)
            ->setTransportStatus($status)
            ->setTransportDetails($order)
            ->setTransport($transport)
            ->setAmount($amount)
            ->setLevied($levied)
            ->setBooking($booking)
        ;

        $this->transactionRepository->save($transaction);

        return $transaction;
    }

    public function retrieveByTransportId(string $transportId): ?Transaction
    {
        return $this->transactionRepository->findOneByTransportId($transportId);
    }
}