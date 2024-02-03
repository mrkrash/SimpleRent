<?php

namespace Tests\Integration\Customer\Infrastructure\Repository;

use App\Customer\Domain\Entity\Customer;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\DTO\CustomerDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Faker;

/**
 * @covers \App\Customer\Infrastructure\Repository\CustomerRepository
 */
class CustomerRepositoryTest extends KernelTestCase
{
    private CustomerRepositoryInterface $customerRepository;
    private Faker\Generator $faker;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->customerRepository = $kernel->getContainer()->get('doctrine')->getRepository(Customer::class);
        $this->faker = Faker\Factory::create();
    }

    public function testSaveCustomer(): void
    {
        $this->customerRepository->save(
            (new Customer())
            ->setFirstname($this->faker->firstName)
            ->setLastname($this->faker->lastName)
            ->setEmail('pippo@pluto.local')
            ->setPhone($this->faker->phoneNumber)
            ->setNewsletter(false)
            ->setPrivacy(true),
            true
        );
        self::assertInstanceOf(Customer::class, $this->customerRepository->findOneBy(['email' => 'pippo@pluto.local']));
    }

    /**
     * @depends testSaveCustomer
     */
    public function testRemoveCustomer(): void
    {
        $previous = count($this->customerRepository->findAll());
        $customer = $this->customerRepository->findOneBy(['email' => 'pippo@pluto.local']);
        $this->customerRepository->remove($customer, true);
        self::assertEquals($previous - 1, count($this->customerRepository->findAll()));
    }

    public function testFindByDto(): void
    {
        $firstname = $this->faker->firstName;
        $lastname = $this->faker->lastName;
        $email = $this->faker->email;
        $phone = $this->faker->phoneNumber;
        $this->customerRepository->save(
            (new Customer())
                ->setFirstname($firstname)
                ->setLastname($lastname)
                ->setEmail($email)
                ->setPhone($phone)
                ->setNewsletter(false)
                ->setPrivacy(true),
            true
        );
        self::assertInstanceOf(
            Customer::class,
            $this->customerRepository->findByDto(
                new CustomerDto(
                    $firstname,
                    $lastname,
                    $phone,
                    $email,
                    true,
                    false
                )
            )
        );
        self::assertNull(
            $this->customerRepository->findByDto(
                new CustomerDto(
                    $firstname,
                    $lastname,
                    $phone,
                    'test@test.local',
                    true,
                    false
                )
            )
        );
    }
}