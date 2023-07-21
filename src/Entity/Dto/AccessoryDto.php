<?php

namespace App\Entity\Dto;

class AccessoryDto implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly string $size,
        private readonly int $qty
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'size'=> $this->size,
            'qty' => $this->qty,
        ];
    }
}