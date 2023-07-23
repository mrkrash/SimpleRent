<?php

namespace App\Shared\Traits;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * ThisTrait adds createdAt field to entity.
 */
trait AutoCreatedAtTrait
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected ?DateTimeInterface $createdAt;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setCreatedAtValue(): self
    {
        $this->createdAt = new DateTimeImmutable();

        return $this;
    }
}