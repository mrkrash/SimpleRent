<?php

namespace App\Site\Affiliate\Domain\Entity;

use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use App\Site\Affiliate\Infrastructure\Repository\AffiliateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: AffiliateRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Affiliate
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $web = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    private ?File $uploadImage;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(?string $web): self
    {
        $this->web = $web;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
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
}
