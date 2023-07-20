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