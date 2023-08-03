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

    #[ORM\OneToOne(mappedBy: 'product', targetEntity: ProductQty::class)]
    private ?ProductQty $productQty = null;

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

    private int $sizeXS = 0;
    private int $sizeS = 0;
    private int $sizeM = 0;
    private int $sizeL = 0;
    private int $sizeXL = 0;

    /**
     * @var ArrayCollection|null <int, BookedProduct>
     */
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: BookedProduct::class, cascade: ['persist'])]
    private ?Collection $bookedProduct = null;

    public function __construct()
    {
        $this->bookedProduct = new ArrayCollection();
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

    public function setPriceList(PriceList $priceList): self
    {
        $this->priceList = $priceList;

        return $this;
    }

    public function getProductQty(): ProductQty
    {
        return $this->productQty;
    }

    public function setProductQty(ProductQty $productQty): self
    {
        $this->productQty = $productQty;

        return $this;
    }

    public function getQty(): int
    {
        if ($this->productQty) {
            return $this->productQty->getSizeXS() +
                $this->productQty->getSizeS() +
                $this->productQty->getSizeM() +
                $this->productQty->getSizeL() +
                $this->productQty->getSizeXL();
        }
        return 0;
    }

    public function populateQty(): void
    {
        if ($this->productQty) {
            $this->sizeXS = $this->productQty->getSizeXs();
            $this->sizeS = $this->productQty->getSizeS();
            $this->sizeM = $this->productQty->getSizeM();
            $this->sizeL = $this->productQty->getSizeL();
            $this->sizeXL = $this->productQty->getSizeXl();
        }
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

    public function getSizeXS(): int
    {
        return $this->sizeXS;
    }

    public function setSizeXS(int $sizeXS): Product
    {
        $this->sizeXS = $sizeXS;
        return $this;
    }

    public function getSizeS(): int
    {
        return $this->sizeS;
    }

    public function setSizeS(int $sizeS): Product
    {
        $this->sizeS = $sizeS;
        return $this;
    }

    public function getSizeM(): int
    {
        return $this->sizeM;
    }

    public function setSizeM(int $sizeM): Product
    {
        $this->sizeM = $sizeM;
        return $this;
    }

    public function getSizeL(): int
    {
        return $this->sizeL;
    }

    public function setSizeL(int $sizeL): Product
    {
        $this->sizeL = $sizeL;
        return $this;
    }

    public function getSizeXL(): int
    {
        return $this->sizeXL;
    }

    public function setSizeXL(int $sizeXL): Product
    {
        $this->sizeXL = $sizeXL;
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
