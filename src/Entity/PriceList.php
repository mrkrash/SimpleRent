<?php

namespace App\Entity;

use App\Entity\Traits\AutoCreatedAtTrait;
use App\Entity\Traits\AutoDeletedAtTrait;
use App\Entity\Traits\AutoUpdatedAtTrait;
use App\Repository\PriceListRepository;
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
    private ?int $price = null;

    #[ORM\Column]
    private ?int $price3days = null;

    #[ORM\Column]
    private ?int $price7days = null;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice3days(): ?int
    {
        return $this->price3days;
    }

    public function setPrice3days(int $price3days): self
    {
        $this->price3days = $price3days;

        return $this;
    }

    public function getPrice7days(): ?int
    {
        return $this->price7days;
    }

    public function setPrice7days(int $price7days): self
    {
        $this->price7days = $price7days;

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
            $product->setPriceListName($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getPriceListName() === $this) {
                $product->setPriceListName(null);
            }
        }

        return $this;
    }
}
