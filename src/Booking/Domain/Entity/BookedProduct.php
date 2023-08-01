<?php

namespace App\Booking\Domain\Entity;

use App\Booking\Infrastructure\Repository\BookedRepository;
use App\Product\Domain\Entity\Product;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookedRepository::class)]
#[ORM\HasLifecycleCallbacks]
class BookedProduct
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $qty = null;

    #[ORM\Column]
    private ?string $size = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Booking $booking = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'bookedProduct')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): BookedProduct
    {
        $this->id = $id;
        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(?int $qty): BookedProduct
    {
        $this->qty = $qty;
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): BookedProduct
    {
        $this->size = $size;
        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}