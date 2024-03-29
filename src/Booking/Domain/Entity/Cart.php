<?php

namespace App\Booking\Domain\Entity;

use App\Booking\Infrastructure\Repository\CartRepository;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: CartRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cart implements JsonSerializable
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(
        mappedBy: 'cart',
        targetEntity: CartItem::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $cartItems;

    #[ORM\Column]
    private int $rate = 0;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $dateStart = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $dateEnd = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeInterface $validUntil;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
        $this->validUntil = (new DateTimeImmutable())->add(new DateInterval('PT40M'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Cart
    {
        $this->id = $id;
        return $this;
    }

    public function getRate(): int
    {
        return $this->rate;
    }

    public function setRate(int $rate): Cart
    {
        $this->rate = $rate;
        return $this;
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

    public function getValidUntil(): ?DateTimeInterface
    {
        return $this->validUntil;
    }

    public function setValidUntil(?DateTimeImmutable $validUntil): Cart
    {
        $this->validUntil = $validUntil;
        return $this;
    }

    /**
     * @return Collection<int, CartItem>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    // @todo If two cart items have same detail, we must increment qty
    public function addCartItem(CartItem $item): self
    {
        if (!$this->cartItems->contains($item)) {
            $this->cartItems->add($item);
            $item->setCart($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $item): self
    {
        if ($this->cartItems->removeElement($item)) {
            if ($item->getCart() === $this) {
                $item->setCart(null);
            }
        }

        return $this;
    }

    public function getTotalItemsCount(): int
    {
        return array_reduce(
            iterator_to_array($this->cartItems),
            fn(int $carry, CartItem $item) => $carry += $item->getQty(),
            0
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'validUntil' => $this->validUntil,
            'count' => $this->getTotalItemsCount(),
            'rate' => $this->rate,
        ];
    }
}
