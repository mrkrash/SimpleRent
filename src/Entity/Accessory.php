<?php

namespace App\Entity;

use App\Entity\Traits\AutoCreatedAtTrait;
use App\Entity\Traits\AutoDeletedAtTrait;
use App\Entity\Traits\AutoUpdatedAtTrait;
use App\Repository\AccessoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: AccessoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Accessory
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private string $image;

    #[ORM\Column]
    private ?int $dailyPrice = null;

    #[ORM\Column]
    private ?int $weekPrice = null;

    private ?File $uploadImage;

    #[ORM\ManyToMany(targetEntity: Booking::class, mappedBy: 'accessories')]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): Accessory
    {
        $this->image = $image;
        return $this;
    }

    public function getDailyPrice(): ?int
    {
        return $this->dailyPrice;
    }

    public function setDailyPrice(int $price): self
    {
        $this->dailyPrice = $price;

        return $this;
    }

    public function getWeekPrice(): ?int
    {
        return $this->weekPrice;
    }

    public function setWeekPrice(?int $weekPrice): Accessory
    {
        $this->weekPrice = $weekPrice;
        return $this;
    }

    public function getUploadImage(): ?File
    {
        return $this->uploadImage;
    }

    public function setUploadImage(File $uploadImage): self
    {
        $this->uploadImage = $uploadImage;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->addAccessory($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeAccessory($this);
        }

        return $this;
    }
}
