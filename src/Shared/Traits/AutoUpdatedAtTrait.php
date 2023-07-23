<?php

namespace App\Shared\Traits;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * ThisTrait adds updatedAt field to entity.
 */
trait AutoUpdatedAtTrait
{
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeInterface $updatedAt;

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): self
    {
        $this->updatedAt = new DateTimeImmutable();

        return $this;
    }
}