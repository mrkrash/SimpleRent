<?php

namespace Integration\Product\Application\Form;

use App\Product\Application\Form\ProductFormType;
use App\Product\Domain\Entity\Product;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\Gender;
use Faker;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @covers \App\Product\Application\Form\ProductFormType
 */
class ProductFormTypeTest extends TypeTestCase
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
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'priceList' => null,
            'bicycleType' => BicycleType::RACINGBIKE->value,
            'sizeXS' => 0,
            'sizeS' => 0,
            'sizeM' => 3,
            'sizeL' => 0,
            'sizeXL' => 1,
            'gender' => Gender::MAN->value,
            'ordering' => 42,
            'enabled' => true,
        ];

        $model = new Product();

        $form = $this->factory->create(ProductFormType::class, $model);

        $expected = (new Product())
            ->setName($formData['name'])
            ->setDescription($formData['description'])
            ->setPriceList($formData['priceList'])
            ->setBicycleType(BicycleType::RACINGBIKE)
            ->setGender(Gender::MAN)
            ->setOrdering($formData['ordering'])
            ->setEnabled($formData['enabled'])
        ;

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);
    }

    public function testProductFormView(): void
    {
        $formData = (new Product())
            ->setName($this->faker->word)
            ->setDescription($this->faker->sentence)
            ->setPriceList(null)
            ->setBicycleType(BicycleType::RACINGBIKE)
            ->setGender(Gender::MAN)
            ->setOrdering(42)
            ->setEnabled(true)
        ;

        $view = $this->factory->create(ProductFormType::class, $formData)->createView();

        $this->assertArrayHasKey('sizeL', $view->vars['form']->children);
        $this->assertSame($formData, $view->vars['value']);
    }
}
