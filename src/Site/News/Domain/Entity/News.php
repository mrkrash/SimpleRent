<?php

namespace App\Site\News\Domain\Entity;

use App\Shared\Enum\Lang;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use App\Site\News\Infrastructure\Repository\NewsRepository;
use App\Site\Shared\Domain\Entity\Slide;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class News
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: "text")]
    private ?string $content = null;

    #[ORM\Column]
    private DateTimeImmutable $date;

    #[ORM\Column(length: 2)]
    private ?Lang $lang = null;

    #[ORM\OneToMany(mappedBy: 'news', targetEntity: Slide::class, cascade: ['persist', 'remove'])]
    private Collection $slides;

    /** @var File[]|null  */
    private ?array $uploadSlides;

    public function __construct()
    {
        $this->slides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): News
    {
        $this->id = $id;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): News
    {
        $this->slug = $slug;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): News
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): News
    {
        $this->content = $content;
        return $this;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): News
    {
        $this->date = $date;
        return $this;
    }

    public function getLang(): ?Lang
    {
        return $this->lang;
    }

    public function setLang(?Lang $lang): News
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return Collection<int, Slide>
     */
    public function getSlides(): Collection
    {
        return $this->slides;
    }

    public function addSlide(Slide $slide): self
    {
        if (!$this->slides->contains($slide)) {
            $this->slides->add($slide);
        }

        return $this;
    }

    public function removeSlide(Slide $slide): self
    {
        if ($this->slides->removeElement($slide)) {
            if ($slide->getPage() === $this) {
                $slide->setPage(null);
            }
        }

        return $this;
    }

    public function getUploadSlides(): ?array
    {
        return $this->uploadSlides;
    }

    public function setUploadSlides(?array $uploadSlides): News
    {
        $this->uploadSlides = $uploadSlides;
        return $this;
    }
}
