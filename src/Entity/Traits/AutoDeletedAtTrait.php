<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait AutoDeletedAtTrait
{
    #[ORM\Column(nullable: true)]
    protected DateTimeInterface $deletedAt;

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    #[ORM\PreRemove]
    public function setDeletedAtValue(): self
    {
        $this->deletedAt = new DateTime();

        return $this;
    }
}