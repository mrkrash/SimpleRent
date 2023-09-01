<?php

namespace App\Product\Domain\Entity;

use App\Product\Infrastructure\Repository\PriceListRepository;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceListRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PriceList
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $priceOneDay = null;

    #[ORM\Column]
    private ?int $priceThreeDays = null;

    #[ORM\Column]
    private ?int $priceSevenDays = null;

    #[ORM\OneToMany(mappedBy: 'priceList', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getPriceOneDay(): ?int
    {
        return $this->priceOneDay;
    }

    public function setPriceOneDay(int $price): self
    {
        $this->priceOneDay = $price;

        return $this;
    }

    public function getPriceThreeDays(): ?int
    {
        return $this->priceThreeDays;
    }

    public function setPriceThreeDays(int $price): self
    {
        $this->priceThreeDays = $price;

        return $this;
    }

    public function getPriceSevenDays(): ?int
    {
        return $this->priceSevenDays;
    }

    public function setPriceSevenDays(int $price): self
    {
        $this->priceSevenDays = $price;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setPriceList($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getPriceList() === $this) {
                $product->setPriceList(null);
            }
        }

        return $this;
    }
}
