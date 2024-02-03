<?php

namespace App\Customer\Domain\Repository;

use App\Customer\Domain\Entity\Customer;
use App\Shared\DTO\CustomerDto;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface CustomerRepositoryInterface
{
    public function save(Customer $entity, bool $flush = false): void;
    public function remove(Customer $entity, bool $flush = false): void;
    public function findByDto(CustomerDto $customerDto): ?Customer;
}