<?php

namespace App\Customer\Domain\Repository;

use App\Customer\Domain\Entity\Customer;
use App\Shared\DTO\CustomerDto;

interface CustomerRepositoryInterface
{
    public function save(Customer $entity, bool $flush = false): void;
    public function remove(Customer $entity, bool $flush = false): void;
    public function findByDto(CustomerDto $customerDto): ?Customer;
}