<?php

namespace App\Cart\Domain\Entity;

use App\Booking\Domain\Entity\Booking;
use App\Cart\Infrastructure\Repository\TransactionRepository;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: 'transations')]
#[ORM\HasLifecycleCallbacks]
class Transaction
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    const STATUS_FRAUD_SUSPECTED = 'Fraud Suspected';
    const STATUS_PAID = 'Order Payed';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private ?string $requestId = null;

    #[ORM\Column(length: 6)]
    private ?string $transport = null;

    #[ORM\Column(length: 32)]
    private ?string $transportId = null;

    #[ORM\Column(length: 40)]
    private ?string $transportStatus = null;

    #[ORM\Column(type: Types::JSON)]
    private ?array $transportDetails;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column]
    private ?int $levied = null;

    #[ORM\OneToOne(mappedBy: 'transaction', cascade: ['persist', 'remove'])]
    private ?Booking $booking = null;

    public function __construct()
    {
        $this->requestId = Uuid::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransport(): ?string
    {
        return $this->transport;
    }

    public function setTransport(string $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getLevied(): ?int
    {
        return $this->levied;
    }

    public function setLevied(int $levied): self
    {
        $this->levied = $levied;

        return $this;
    }

    public function getTransportId(): ?string
    {
        return $this->transportId;
    }

    public function setTransportId(?string $transportId): Transaction
    {
        $this->transportId = $transportId;
        return $this;
    }

    public function getTransportStatus(): ?string
    {
        return $this->transportStatus;
    }

    public function setTransportStatus(?string $transportStatus): Transaction
    {
        $this->transportStatus = $transportStatus;
        return $this;
    }

    public function getTransportDetails(): ?array
    {
        return $this->transportDetails;
    }

    public function setTransportDetails(?array $transportDetails): Transaction
    {
        $this->transportDetails = $transportDetails;
        return $this;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public function setRequestId(?string $requestId): Transaction
    {
        $this->requestId = $requestId;
        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): self
    {
        $this->booking = $booking;

        return $this;
    }
}
