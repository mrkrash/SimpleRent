<?php

namespace Tests\Unit\Product\Domain\Entity;

use App\Booking\Domain\Entity\BookedProduct;
use App\Product\Domain\Entity\PriceList;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\Gender;
use App\Shared\Enum\ProductType;
use Mockery;
use ReflectionClass;
use Symfony\Component\HttpFoundation\File\File;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEmpty;

/**
 * Class ProductTest.
 *
 * @covers \App\Product\Domain\Entity\Product
 */
final class ProductTest extends TestCase
{
    private Product $product;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = new Product();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->product);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Product::class))
            ->getProperty('id');
        $property->setValue($this->product, $expected);
        $this->assertSame($expected, $this->product->getId());
    }

    public function testBicycleType(): void
    {
        $expected = BicycleType::GRAVEL;
        $this->product->setBicycleType($expected);
        $this->assertSame($expected, $this->product->getBicycleType());
    }

    public function testType(): void
    {
        $expected = ProductType::BYCICLE;
        $this->product->setType($expected);
        $this->assertSame($expected, $this->product->getType());
    }

    public function testName(): void
    {
        $expected = '42';
        $this->product->setName($expected);
        $this->assertSame($expected, $this->product->getName());
    }

    public function testDescription(): void
    {
        $expected = '42';
        $this->product->setDescription($expected);
        $this->assertSame($expected, $this->product->getDescription());
    }

    public function testImage(): void
    {
        $expected = '42';
        $this->product->setImage($expected);
        $this->assertSame($expected, $this->product->getImage());
    }

    public function testPriceList(): void
    {
        $expected = Mockery::mock(PriceList::class);
        $this->product->setPriceList($expected);
        $this->assertSame($expected, $this->product->getPriceList());
    }

    public function testProductQty(): void
    {
        self::assertEmpty($this->product->getProductQty());
        $productQty = Mockery::mock(ProductQty::class);
        $productQty->shouldReceive('setProduct')->with($this->product);
        $productQty->shouldReceive('getProduct')->andReturn($this->product);
        $productQty->shouldReceive('setProduct')->with(null);
        $this->product->addProductQty($productQty);
        self::assertEquals(1, $this->product->getProductQty()->count());
        $this->product->addProductQty($productQty);
        self::assertEquals(1, $this->product->getProductQty()->count());
        $this->product->removeProductQty($productQty);
        self::assertEmpty($this->product->getProductQty());
    }

    public function testGetQty(): void
    {
        $productQty1 = Mockery::mock(ProductQty::class);
        $productQty1->shouldReceive('getQty')->andReturn(3);
        $productQty1->shouldReceive('setProduct')->with($this->product);
        $productQty2 = Mockery::mock(ProductQty::class);
        $productQty2->shouldReceive('getQty')->andReturn(5);
        $productQty2->shouldReceive('setProduct')->with($this->product);
        $this->product->addProductQty($productQty1);
        $this->product->addProductQty($productQty2);
        self::assertEquals(8, $this->product->getQty());
    }

    public function testGender(): void
    {
        $expected = Gender::MAN;
        $this->product->setGender($expected);
        $this->assertSame($expected, $this->product->getGender());
    }

    public function testEnabled(): void
    {
        $this->product->setEnabled(true);
        self::assertTrue($this->product->isEnabled());
    }

    public function testOrdering(): void
    {
        $expected = 42;
        $this->product->setOrdering($expected);
        $this->assertSame($expected, $this->product->getOrdering());
    }

    public function testUploadImage(): void
    {
        $expected = Mockery::mock(File::class);
        $this->product->setUploadImage($expected);
        $this->assertSame($expected, $this->product->getUploadImage());
    }

    public function testProduct(): void
    {
        self::assertEmpty($this->product->getBookedProduct());
        $bookedProduct = Mockery::mock(BookedProduct::class);
        $bookedProduct->shouldReceive('setProduct')->with($this->product);
        $bookedProduct->shouldReceive('getProduct')->andReturn($this->product);
        $bookedProduct->shouldReceive('setProduct')->with(null);
        $this->product->addProduct($bookedProduct);
        self::assertEquals(1, $this->product->getBookedProduct()->count());
        $this->product->addProduct($bookedProduct);
        self::assertEquals(1, $this->product->getBookedProduct()->count());
        $this->product->removeProduct($bookedProduct);
        assertEmpty($this->product->getBookedProduct());
    }
}
