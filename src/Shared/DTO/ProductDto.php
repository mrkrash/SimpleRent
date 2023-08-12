<?php

namespace App\Shared\DTO;

class ProductDto
{
    public function __construct(
        private readonly int $idx,
        private readonly string $name,
        private readonly string $image,
        private readonly string $size,
        private readonly int $qty,
    ) {
    }

    public function getIdx(): int
    {
        return $this->idx;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getQty(): int
    {
        return $this->qty;
    }
}
