<?php

namespace App\Product\Domain\Entity;

use App\Booking\Domain\Entity\Booking;
use App\Product\Infrastructure\Repository\AccessoryRepository;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
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

    #[ORM\OneToOne(mappedBy: 'accessory', targetEntity: AccessoryQty::class)]
    private ?AccessoryQty $accessoryQty = null;

    #[ORM\Column]
    private ?int $dailyPrice = null;

    #[ORM\Column]
    private ?int $weekPrice = null;

    private ?File $uploadImage;

    private int $sizeXS = 0;
    private int $sizeS = 0;
    private int $sizeM = 0;
    private int $sizeL = 0;
    private int $sizeXL = 0;
    private int $size36 = 0;
    private int $size37 = 0;
    private int $size38 = 0;
    private int $size39 = 0;
    private int $size40 = 0;
    private int $size41 = 0;
    private int $size42 = 0;
    private int $size43 = 0;
    private int $size44 = 0;
    private int $size45 = 0;
    private int $size46 = 0;
    private int $size47 = 0;

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

    public function getAccessoryQty(): AccessoryQty
    {
        return $this->accessoryQty;
    }

    public function setAccessoryQty(AccessoryQty $accessoryQty): self
    {
        $this->accessoryQty = $accessoryQty;

        return $this;
    }

    public function getQty(): int
    {
        if ($this->accessoryQty) {
            return $this->accessoryQty->getSizeXS() +
                $this->accessoryQty->getSizeS() +
                $this->accessoryQty->getSizeM() +
                $this->accessoryQty->getSizeL() +
                $this->accessoryQty->getSizeXL() +
                $this->accessoryQty->getSize36() +
                $this->accessoryQty->getSize37() +
                $this->accessoryQty->getSize38() +
                $this->accessoryQty->getSize39() +
                $this->accessoryQty->getSize40() +
                $this->accessoryQty->getSize41() +
                $this->accessoryQty->getSize42() +
                $this->accessoryQty->getSize43() +
                $this->accessoryQty->getSize44() +
                $this->accessoryQty->getSize45() +
                $this->accessoryQty->getSize46() +
                $this->accessoryQty->getSize47();
        }
        return 0;
    }

    public function populateQty(): void
    {
        if ($this->accessoryQty) {
            $this->sizeXS = $this->accessoryQty->getSizeXs();
            $this->sizeS = $this->accessoryQty->getSizeS();
            $this->sizeM = $this->accessoryQty->getSizeM();
            $this->sizeL = $this->accessoryQty->getSizeL();
            $this->sizeXL = $this->accessoryQty->getSizeXl();
            $this->size36 = $this->accessoryQty->getSize36();
            $this->size37 = $this->accessoryQty->getSize37();
            $this->size38 = $this->accessoryQty->getSize38();
            $this->size39 = $this->accessoryQty->getSize39();
            $this->size40 = $this->accessoryQty->getSize40();
            $this->size41 = $this->accessoryQty->getSize41();
            $this->size42 = $this->accessoryQty->getSize42();
            $this->size43 = $this->accessoryQty->getSize43();
            $this->size44 = $this->accessoryQty->getSize44();
            $this->size45 = $this->accessoryQty->getSize45();
            $this->size46 = $this->accessoryQty->getSize46();
            $this->size47 = $this->accessoryQty->getSize47();
        }
    }

    public function getSizeXS(): int
    {
        return $this->sizeXS;
    }

    public function setSizeXS(int $sizeXS): Accessory
    {
        $this->sizeXS = $sizeXS;
        return $this;
    }

    public function getSizeS(): int
    {
        return $this->sizeS;
    }

    public function setSizeS(int $sizeS): Accessory
    {
        $this->sizeS = $sizeS;
        return $this;
    }

    public function getSizeM(): int
    {
        return $this->sizeM;
    }

    public function setSizeM(int $sizeM): Accessory
    {
        $this->sizeM = $sizeM;
        return $this;
    }

    public function getSizeL(): int
    {
        return $this->sizeL;
    }

    public function setSizeL(int $sizeL): Accessory
    {
        $this->sizeL = $sizeL;
        return $this;
    }

    public function getSizeXL(): int
    {
        return $this->sizeXL;
    }

    public function setSizeXL(int $sizeXL): Accessory
    {
        $this->sizeXL = $sizeXL;
        return $this;
    }

    public function getSize36(): int
    {
        return $this->size36;
    }

    public function setSize36(int $size36): Accessory
    {
        $this->size36 = $size36;
        return $this;
    }

    public function getSize37(): int
    {
        return $this->size37;
    }

    public function setSize37(int $size37): Accessory
    {
        $this->size37 = $size37;
        return $this;
    }

    public function getSize38(): int
    {
        return $this->size38;
    }

    public function setSize38(int $size38): Accessory
    {
        $this->size38 = $size38;
        return $this;
    }

    public function getSize39(): int
    {
        return $this->size39;
    }

    public function setSize39(int $size39): Accessory
    {
        $this->size39 = $size39;
        return $this;
    }

    public function getSize40(): int
    {
        return $this->size40;
    }

    public function setSize40(int $size40): Accessory
    {
        $this->size40 = $size40;
        return $this;
    }

    public function getSize41(): int
    {
        return $this->size41;
    }

    public function setSize41(int $size41): Accessory
    {
        $this->size41 = $size41;
        return $this;
    }

    public function getSize42(): int
    {
        return $this->size42;
    }

    public function setSize42(int $size42): Accessory
    {
        $this->size42 = $size42;
        return $this;
    }

    public function getSize43(): int
    {
        return $this->size43;
    }

    public function setSize43(int $size43): Accessory
    {
        $this->size43 = $size43;
        return $this;
    }

    public function getSize44(): int
    {
        return $this->size44;
    }

    public function setSize44(int $size44): Accessory
    {
        $this->size44 = $size44;
        return $this;
    }

    public function getSize45(): int
    {
        return $this->size45;
    }

    public function setSize45(int $size45): Accessory
    {
        $this->size45 = $size45;
        return $this;
    }

    public function getSize46(): int
    {
        return $this->size46;
    }

    public function setSize46(int $size46): Accessory
    {
        $this->size46 = $size46;
        return $this;
    }

    public function getSize47(): int
    {
        return $this->size47;
    }

    public function setSize47(int $size47): Accessory
    {
        $this->size47 = $size47;
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
