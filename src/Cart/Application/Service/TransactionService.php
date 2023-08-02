<?php

namespace App\Cart\Application\Service;

use App\Booking\Domain\Entity\Booking;
use App\Cart\Domain\Entity\Transaction;
use App\Cart\Domain\Repository\TransactionRepositoryInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;

class TransactionService
{
    public function __construct(
        private readonly TransportInterface $mailer,
        private readonly TransactionRepositoryInterface $transactionRepository,
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

        $this->transactionRepository->save($transaction, true);

        return $transaction;
    }

    public function retrieveByTransportId(string $transportId): ?Transaction
    {
        return $this->transactionRepository->findOneByTransportId($transportId);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function notifyPeers(Transaction $transaction): void
    {
        $email = (new TemplatedEmail())
            ->from('noreply@mcrentbikeragusa.com')
            ->to(new Address($transaction->getBooking()->getCustomer()->getEmail()))
            ->replyTo('info@mcrentbikeragusa.com')
            ->subject('La tua prenotazione')
            ->htmlTemplate('emails/customerConfirmation.html.twig')
            ->context([
                'customer' => $transaction->getBooking()->getCustomer(),
                'booking' => $transaction->getBooking(),
            ])
        ;
        $this->mailer->send($email);

        $email = (new TemplatedEmail())
            ->from('noreply@mcrentbikeragusa.com')
            ->to('info@mcrentbikeragusa.com')
            ->replyTo(new Address($transaction->getBooking()->getCustomer()->getEmail()))
            ->subject('Una nuova prenotazione')
            ->htmlTemplate('emails/newBooking.html.twig')
            ->context([
                'customer' => $transaction->getBooking()->getCustomer(),
                'booking' => $transaction->getBooking(),
            ])
        ;
        $this->mailer->send($email);
    }
}