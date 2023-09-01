<?php

namespace App\Product\Domain\Entity;

use App\Booking\Domain\Entity\BookedProduct;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\Gender;
use App\Shared\Enum\ProductType;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 7)]
    private ProductType $type;

    #[ORM\Column(length: 16, nullable: true)]
    private BicycleType $bicycleType;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private string $image;

    /**
     * @var ArrayCollection|null<int|string, ProductQty>
     */
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductQty::class, cascade:['persist', 'remove'])]
    private ?Collection $productQty;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PriceList $priceList = null;

    #[ORM\Column]
    private Gender $gender;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[ORM\Column]
    private ?int $ordering = null;

    private ?File $uploadImage;

    /**
     * @var ArrayCollection|null<int, BookedProduct>
     */
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: BookedProduct::class, cascade: ['persist'])]
    private ?Collection $bookedProduct;

    public function __construct()
    {
        $this->bookedProduct = new ArrayCollection();
        $this->productQty = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ProductType
    {
        return $this->type;
    }

    public function getBicycleType(): BicycleType
    {
        return $this->bicycleType;
    }

    public function setBicycleType(BicycleType $bicycleType): Product
    {
        $this->bicycleType = $bicycleType;
        return $this;
    }

    public function setType(ProductType $type): Product
    {
        $this->type = $type;
        return $this;
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

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getPriceList(): ?PriceList
    {
        return $this->priceList;
    }

    public function setPriceList(?PriceList $priceList): self
    {
        $this->priceList = $priceList;

        return $this;
    }

    /**
     * @return ArrayCollection<int|string, ProductQty>
     */
    public function getProductQty(): ArrayCollection
    {
        return $this->productQty;
    }

    public function addProductQty(ProductQty $productQty): self
    {
        if (!$this->productQty->contains($productQty)) {
            $this->productQty->add($productQty);
            $productQty->setProduct($this);
        }

        return $this;
    }

    public function removeProductQty(ProductQty $productQty): self
    {
        if ($this->productQty->removeElement($productQty)) {
            if ($productQty->getProduct() === $this) {
                $productQty->setProduct(null);
            }
        }

        return $this;
    }

    public function getQty(): int
    {
        return array_reduce($this->productQty->toArray(), function (int $carry, ProductQty $qty) {
            return $carry + $qty->getQty();
        }, 0);
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): Product
    {
        $this->gender = $gender;
        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getOrdering(): ?int
    {
        return $this->ordering;
    }

    public function setOrdering(int $ordering): self
    {
        $this->ordering = $ordering;

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

    public function getBookedProduct(): ?Collection
    {
        return $this->bookedProduct;
    }

    public function addProduct(BookedProduct $product): self
    {
        if (!$this->bookedProduct->contains($product)) {
            $this->bookedProduct->add($product);
            $product->setProduct($this);
        }

        return $this;
    }

    public function removeProduct(BookedProduct $product): self
    {
        if ($this->bookedProduct->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getProduct() === $this) {
                $product->setProduct(null);
            }
        }

        return $this;
    }
}
