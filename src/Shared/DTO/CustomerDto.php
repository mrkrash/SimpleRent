<?php

namespace App\Shared\DTO;

class CustomerDto
{
    public function __construct(
        private readonly string $firstname,
        private readonly string $lastname,
        private readonly string $phone,
        private readonly string $email,
        private readonly bool $privacy,
        private readonly bool $newsletter,
    ) {
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function wantNewsletter(): bool
    {
        return $this->newsletter;
    }

    public function acceptPrivacy(): bool
    {
        return $this->privacy;
    }

}