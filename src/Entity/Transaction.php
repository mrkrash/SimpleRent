<?php

namespace App\Entity;

use App\Entity\Traits\AutoCreatedAtTrait;
use App\Entity\Traits\AutoDeletedAtTrait;
use App\Entity\Traits\AutoUpdatedAtTrait;
use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: 'transations')]
#[ORM\HasLifecycleCallbacks]
class Transaction
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    private ?string $transport = null;

    #[ORM\Column(length: 32)]
    private ?string $transport_id = null;

    #[ORM\Column(length: 40)]
    private ?string $transport_status = null;

    #[ORM\Column(type: Types::JSON)]
    private ?array $transport_details;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column]
    private ?int $levied = null;

    #[ORM\OneToOne(mappedBy: 'paymentTransaction', cascade: ['persist', 'remove'])]
    private ?Booking $booking = null;

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
        return $this->transport_id;
    }

    public function setTransportId(?string $transport_id): Transaction
    {
        $this->transport_id = $transport_id;
        return $this;
    }

    public function getTransportStatus(): ?string
    {
        return $this->transport_status;
    }

    public function setTransportStatus(?string $transport_status): Transaction
    {
        $this->transport_status = $transport_status;
        return $this;
    }

    public function getTransportDetails(): ?array
    {
        return $this->transport_details;
    }

    public function setTransportDetails(?array $transport_details): Transaction
    {
        $this->transport_details = $transport_details;
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
