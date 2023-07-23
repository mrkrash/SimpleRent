<?php

namespace App\Product\Domain\Entity;

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
    private int $sizeXs = 0;
    #[ORM\Column]
    private int $sizeS = 0;
    #[ORM\Column]
    private int $sizeM = 0;
    #[ORM\Column]
    private int $sizeL = 0;
    #[ORM\Column]
    private int $sizeXl = 0;
    #[ORM\OneToOne(inversedBy: 'productQty', targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    public function getSizeXS(): int
    {
        return $this->sizeXs;
    }

    public function getSizeS(): int
    {
        return $this->sizeS;
    }

    public function getSizeM(): int
    {
        return $this->sizeM;
    }

    public function getSizeL(): int
    {
        return $this->sizeL;
    }

    public function getSizeXL(): int
    {
        return $this->sizeXl;
    }

    public function setSizeXs(int $sizeXs): ProductQty
    {
        $this->sizeXs = $sizeXs;
        return $this;
    }

    public function setSizeS(int $sizeS): ProductQty
    {
        $this->sizeS = $sizeS;
        return $this;
    }

    public function setSizeM(int $sizeM): ProductQty
    {
        $this->sizeM = $sizeM;
        return $this;
    }

    public function setSizeL(int $sizeL): ProductQty
    {
        $this->sizeL = $sizeL;
        return $this;
    }

    public function setSizeXl(int $sizeXl): ProductQty
    {
        $this->sizeXl = $sizeXl;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): ProductQty
    {
        $this->product = $product;

        return $this;
    }

    public function __toArray(): array
    {
        $result = [];
        if ($this->sizeXs) {
            $result['XS'] = $this->sizeXs;
        }
        if ($this->sizeS) {
            $result['S'] = $this->sizeS;
        }
        if ($this->sizeM) {
            $result['M'] = $this->sizeM;
        }
        if ($this->sizeL) {
            $result['L'] = $this->sizeL;
        }
        if ($this->sizeXl) {
            $result['XL'] = $this->sizeXL;
        }

        return $result;
    }

    public function __toString(): string
    {
        $result = [];
        if ($this->sizeXs) {
            $result[] = 'XS';
        }
        if ($this->sizeS) {
            $result[] = 'S';
        }
        if ($this->sizeM) {
            $result[] = 'M';
        }
        if ($this->sizeL) {
            $result[] = 'L';
        }
        if ($this->sizeXl) {
            $result[] = 'XL';
        }

        return implode('/', $result);
    }
}