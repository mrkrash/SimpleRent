<?php

namespace App\Booking\Domain\Entity;

use App\Booking\Infrastructure\Repository\BookingRepository;
use App\Customer\Domain\Entity\Customer;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Booking
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $dateStart = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $dateEnd = null;

    #[ORM\Column(length: 5000, nullable: true)]
    private ?string $notes = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\OneToOne(inversedBy: 'booking')]
    private ?Transaction $transaction;

    #[ORM\Column]
    private int $rate = 0;

    #[ORM\OneToMany(mappedBy: 'booking', targetEntity: BookedProduct::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $bookedProduct;

    public function __construct()
    {
        $this->bookedProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?DateTimeImmutable
    {
        return $this->dateStart;
    }

    public function setDateStart(DateTimeImmutable $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function setDateEnd(DateTimeImmutable $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getRate(): int
    {
        return $this->rate;
    }

    public function setRate(int $rate): Booking
    {
        $this->rate = $rate;
        return $this;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): Booking
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @return Collection<int, BookedProduct>
     */
    public function getBookedProduct(): Collection
    {
        return $this->bookedProduct;
    }

    public function addProduct(BookedProduct $product): self
    {
        if (!$this->bookedProduct->contains($product)) {
            $this->bookedProduct->add($product);
            $product->setBooking($this);
        }

        return $this;
    }

    public function removeProduct(BookedProduct $product): self
    {
        if ($this->bookedProduct->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBooking() === $this) {
                $product->setBooking(null);
            }
        }

        return $this;
    }
}
