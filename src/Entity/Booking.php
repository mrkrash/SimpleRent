<?php

namespace App\Entity;

use App\Entity\Dto\AccessoryDto;
use App\Entity\Dto\ProductDto;
use App\Entity\Traits\AutoCreatedAtTrait;
use App\Entity\Traits\AutoDeletedAtTrait;
use App\Entity\Traits\AutoUpdatedAtTrait;
use App\Repository\BookingRepository;
use DateTimeImmutable;
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

    #[ORM\Column(type: Types::JSON)]
    private ?array $products;

    #[ORM\Column(type: Types::JSON)]
    private ?array $accessories;

    public function __construct()
    {
        $this->products = [];
        $this->accessories = [];
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

    /**
     * @return ProductDto[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function addProduct(ProductDto $product): self
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * @return AccessoryDto[]
     */
    public function getAccessories(): array
    {
        return $this->accessories;
    }

    public function addAccessory(AccessoryDto $accessory): self
    {
        $this->accessories[] = $accessory;

        return $this;
    }

}
