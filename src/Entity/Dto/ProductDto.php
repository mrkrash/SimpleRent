<?php

namespace App\Entity\Dto;

class ProductDto implements \JsonSerializable
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $size,
        private readonly string $image,
        private readonly int $qty,
        private readonly int $rate
    )
    {
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

    public function getRate(): int
    {
        return $this->rate;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'size'=> $this->size,
            'image' => $this->image,
            'qty' => $this->qty,
            'rate' => $this->rate,
        ];
    }

    public function forPaypal(): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->qty,
            'unit_amount' => [
                'currency_code' => 'EUR',
                'value' => $this->rate,
            ],
        ];
    }
}