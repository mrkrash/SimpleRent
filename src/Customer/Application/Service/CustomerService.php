<?php

namespace App\Customer\Application\Service;

use App\Customer\Domain\Entity\Customer;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\DTO\CustomerDto;

class CustomerService
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository
    ) {
    }

    public function handle(CustomerDto $customerDto): Customer
    {
        $customer = $this->customerRepository->findByDto($customerDto);
        if (null === $customer) {
            $customer = (new Customer())
                ->setFirstname($customerDto->getFirstname())
                ->setLastname($customerDto->getLastname())
                ->setEmail($customerDto->getEmail())
                ->setPhone($customerDto->getPhone())
                ->setPrivacy($customerDto->acceptPrivacy())
                ->setNewsletter($customerDto->wantNewsletter())
            ;
            $this->customerRepository->save($customer, true);
        }

        return $customer;
    }
}