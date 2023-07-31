<?php

namespace App\Cart\Domain\Entity;

use App\Cart\Infrastructure\Repository\CartItemRepository;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CartItem implements JsonSerializable
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ["persist"], inversedBy: 'cartItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $cart = null;
    #[ORM\Column(nullable: true)]
    private ?int $productId = null;
    #[ORM\Column(nullable: true)]
    private ?int $accessoryId = null;
    #[ORM\Column]
    private int $qty = 0;
    #[ORM\Column]
    private string $size;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): CartItem
    {
        $this->id = $id;
        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): CartItem
    {
        $this->cart = $cart;
        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }

    public function setProductId(?int $productId): CartItem
    {
        $this->productId = $productId;
        return $this;
    }

    public function getAccessoryId(): ?int
    {
        return $this->accessoryId;
    }

    public function setAccessoryId(?int $accessoryId): CartItem
    {
        $this->accessoryId = $accessoryId;
        return $this;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setQty(int $qty): CartItem
    {
        $this->qty = $qty;
        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): CartItem
    {
        $this->size = $size;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'productId' => $this->productId,
            'qty' => $this->qty,
            'size' => $this->size,
        ];
    }
}