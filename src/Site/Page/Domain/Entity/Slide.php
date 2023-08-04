<?php

namespace App\Site\Page\Domain\Entity;

use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use App\Site\Page\Infrastructure\Repository\SlideRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: SlideRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Slide
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Page::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $page = null;

    private ?File $uploadImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Slide
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Slide
    {
        $this->name = $name;
        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): Slide
    {
        $this->page = $page;
        return $this;
    }

    public function getUploadImage(): ?File
    {
        return $this->uploadImage;
    }

    public function setUploadImage(?File $uploadImage): Slide
    {
        $this->uploadImage = $uploadImage;
        return $this;
    }
}
