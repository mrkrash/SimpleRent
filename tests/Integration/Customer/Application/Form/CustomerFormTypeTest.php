<?php

namespace Tests\Integration\Customer\Application\Form;

use App\Customer\Application\Form\CustomerFormType;
use App\Customer\Domain\Entity\Customer;
use Faker;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @covers \App\Customer\Application\Form\CustomerFormType
 * @covers \App\Customer\Domain\Entity\Customer
 */
class CustomerFormTypeTest extends TypeTestCase
{
    private Faker\Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker\Factory::create();
    }

    public function testSubmitValidData(): void
    {
        $formData = [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];

        $model = new Customer();

        $form = $this->factory->create(CustomerFormType::class, $model);

        $expected = (new Customer())
            ->setFirstname($formData['firstname'])
            ->setLastname($formData['lastname'])
            ->setEmail($formData['email'])
            ->setPhone($formData['phone'])
        ;

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);
    }

    public function testCustomerFormView(): void
    {
        $formData = (new Customer())
            ->setFirstname($this->faker->firstName)
            ->setLastname($this->faker->lastName)
            ->setEmail($this->faker->email)
            ->setPhone($this->faker->phoneNumber)
        ;
        // ... prepare the data as you need

        // The initial data may be used to compute custom view variables
        $view = $this->factory->create(CustomerFormType::class, $formData)
            ->createView();

        $this->assertArrayHasKey('email', $view->vars['form']->children);
        $this->assertSame($formData, $view->vars['value']);
    }
}
