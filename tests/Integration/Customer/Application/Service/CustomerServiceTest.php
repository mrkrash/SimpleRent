<?php

namespace Tests\Integration\Customer\Application\Service;

use App\Customer\Application\Service\CustomerService;
use App\Customer\Domain\Entity\Customer;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\DTO\CustomerDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Faker;

/**
 * @covers \App\Customer\Application\Service\CustomerService
 * @covers \App\Customer\Infrastructure\Repository\CustomerRepository
 * @covers \App\Shared\DTO\CustomerDto
 */
class CustomerServiceTest extends KernelTestCase
{
    private CustomerRepositoryInterface $customerRepository;
    private CustomerService $customerService;
    private Faker\Generator $faker;
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->customerRepository = $kernel->getContainer()->get('doctrine')->getRepository(Customer::class);
        $this->customerService = new CustomerService($this->customerRepository);
        $this->faker = Faker\Factory::create();
    }

    public function testHandle(): void
    {
        $customer = (new Customer())
            ->setFirstname($this->faker->firstName)
            ->setLastname($this->faker->lastName)
            ->setEmail('pippo@pluto.local')
            ->setPhone($this->faker->phoneNumber)
            ->setNewsletter(false)
            ->setPrivacy(true);
        $this->customerRepository->save(
            $customer,
            true
        );
        $existingCustomer = new CustomerDto(
            $customer->getFirstname(),
            $customer->getLastname(),
            $customer->getPhone(),
            $customer->getEmail(),
            $customer->getPrivacy(),
            $customer->getNewsletter()
        );
        self::assertEquals($customer, $this->customerService->handle($existingCustomer));
        $customerDto = new CustomerDto(
            $this->faker->firstName,
            $this->faker->lastName,
            $this->faker->phoneNumber,
            $this->faker->email,
            true,
            false
        );
        $newCustomer = $this->customerService->handle($customerDto);
        self::assertInstanceOf(Customer::class, $newCustomer);
        self::assertEquals($customerDto->getEmail(), $newCustomer->getEmail());
        self::assertEquals($customer->getId() + 1, $newCustomer->getId());
    }
}
