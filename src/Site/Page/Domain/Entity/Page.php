<?php

namespace App\Site\Page\Domain\Entity;

use App\Shared\Enum\Lang;
use App\Shared\Traits\AutoCreatedAtTrait;
use App\Shared\Traits\AutoDeletedAtTrait;
use App\Shared\Traits\AutoUpdatedAtTrait;
use App\Site\Page\Infrastructure\Repository\PageRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Page
{
    use AutoCreatedAtTrait;
    use AutoUpdatedAtTrait;
    use AutoDeletedAtTrait;

    public const STANDARD = 'standard';
    public const NEWS = 'news';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    private string $type = self::STANDARD;

    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column()]
    private ?DateTimeImmutable $date = null;

    #[ORM\Column(type: "text")]
    private ?string $content = null;

    #[ORM\Column(length: 2)]
    private ?Lang $lang = null;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Slide::class, cascade: ['persist', 'remove'])]
    private Collection $slides;

    private ?string $primaryImage = null;

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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Page
    {
        $this->type = $type;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): Page
    {
        $this->slug = $slug;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(?DateTimeImmutable $date): Page
    {
        $this->date = $date;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getLang(): ?Lang
    {
        return $this->lang;
    }

    public function setLang(?Lang $lang): Page
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

    public function setUploadSlides(?array $uploadSlides): Page
    {
        $this->uploadSlides = $uploadSlides;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function getPrimaryImage(): ?string
    {
        if ($this->slides->count() > 0) {
            return $this->slides->getIterator()[0]->getName();
        }

        return null;
    }
}
