<?php

namespace App\Entity\Dto;

class ProductDto implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $size,
        private readonly string $image,
        private readonly int $qty
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'size'=> $this->size,
            'image' => $this->image,
            'qty' => $this->qty,
        ];
    }
}