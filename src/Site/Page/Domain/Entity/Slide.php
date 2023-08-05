<?php

namespace App\Site\Page\Domain\Entity;

use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use App\Site\Page\Infrastructure\Repository\SlideRepository;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\ManyToOne(targetEntity: Page::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $page = null;

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
}
