<?php

namespace App\Entity;

use App\Entity\Traits\AutoCreatedAtTrait;
use App\Entity\Traits\AutoDeletedAtTrait;
use App\Entity\Traits\AutoUpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class AccessoryQty
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
    #[ORM\Column]
    private int $size36 = 0;
    #[ORM\Column]
    private int $size37 = 0;
    #[ORM\Column]
    private int $size38 = 0;
    #[ORM\Column]
    private int $size39 = 0;
    #[ORM\Column]
    private int $size40 = 0;
    #[ORM\Column]
    private int $size41 = 0;
    #[ORM\Column]
    private int $size42 = 0;
    #[ORM\Column]
    private int $size43 = 0;
    #[ORM\Column]
    private int $size44 = 0;
    #[ORM\Column]
    private int $size45 = 0;
    #[ORM\Column]
    private int $size46 = 0;
    #[ORM\Column]
    private int $size47 = 0;

    #[ORM\OneToOne(inversedBy: 'accessoryQty', targetEntity: Accessory::class)]
    #[ORM\JoinColumn(name: 'accessory_id', referencedColumnName: 'id')]
    private Accessory $accessory;

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

    public function getSize36(): int
    {
        return $this->size36;
    }

    public function getSize37(): int
    {
        return $this->size37;
    }

    public function getSize38(): int
    {
        return $this->size38;
    }

    public function getSize39(): int
    {
        return $this->size39;
    }

    public function getSize40(): int
    {
        return $this->size40;
    }

    public function getSize41(): int
    {
        return $this->size41;
    }

    public function getSize42(): int
    {
        return $this->size42;
    }

    public function getSize43(): int
    {
        return $this->size43;
    }

    public function getSize44(): int
    {
        return $this->size44;
    }

    public function getSize45(): int
    {
        return $this->size45;
    }

    public function getSize46(): int
    {
        return $this->size46;
    }

    public function getSize47(): int
    {
        return $this->size47;
    }

    public function setSizeXs(int $sizeXs): AccessoryQty
    {
        $this->sizeXs = $sizeXs;
        return $this;
    }

    public function setSizeS(int $sizeS): AccessoryQty
    {
        $this->sizeS = $sizeS;
        return $this;
    }

    public function setSizeM(int $sizeM): AccessoryQty
    {
        $this->sizeM = $sizeM;
        return $this;
    }

    public function setSizeL(int $sizeL): AccessoryQty
    {
        $this->sizeL = $sizeL;
        return $this;
    }

    public function setSizeXl(int $sizeXl): AccessoryQty
    {
        $this->sizeXl = $sizeXl;
        return $this;
    }

    public function setSize36(int $size36): AccessoryQty
    {
        $this->size36 = $size36;
        return $this;
    }

    public function setSize37(int $size37): AccessoryQty
    {
        $this->size37 = $size37;
        return $this;
    }

    public function setSize38(int $size38): AccessoryQty
    {
        $this->size38 = $size38;
        return $this;
    }

    public function setSize39(int $size39): AccessoryQty
    {
        $this->size39 = $size39;
        return $this;
    }

    public function setSize40(int $size40): AccessoryQty
    {
        $this->size40 = $size40;
        return $this;
    }

    public function setSize41(int $size41): AccessoryQty
    {
        $this->size41 = $size41;
        return $this;
    }

    public function setSize42(int $size42): AccessoryQty
    {
        $this->size42 = $size42;
        return $this;
    }

    public function setSize43(int $size43): AccessoryQty
    {
        $this->size43 = $size43;
        return $this;
    }

    public function setSize44(int $size44): AccessoryQty
    {
        $this->size44 = $size44;
        return $this;
    }

    public function setSize45(int $size45): AccessoryQty
    {
        $this->size45 = $size45;
        return $this;
    }

    public function setSize46(int $size46): AccessoryQty
    {
        $this->size46 = $size46;
        return $this;
    }

    public function setSize47(int $size47): AccessoryQty
    {
        $this->size47 = $size47;
        return $this;
    }

    public function getAccessory(): Accessory
    {
        return $this->accessory;
    }

    public function setAccessory(Accessory $accessory): AccessoryQty
    {
        $this->accessory = $accessory;

        return $this;
    }
}