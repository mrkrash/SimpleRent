<?php

namespace App\Product\Domain\Entity;

use App\Shared\Enum\ProductSize;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class ProductQty
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?ProductSize $size;

    #[ORM\Column]
    private int $qty = 0;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'productQty')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'cascade')]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): ?ProductSize
    {
        return $this->size;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setSize(ProductSize $size): ProductQty
    {
        $this->size = $size;
        return $this;
    }

    public function setQty(int $qty): ProductQty
    {
        $this->qty = $qty;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): ProductQty
    {
        $this->product = $product;

        return $this;
    }
}
