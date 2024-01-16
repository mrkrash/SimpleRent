<?php

namespace Tests\Unit\Product\Domain\Entity;

use App\Product\Domain\Entity\PriceList;
use App\Product\Domain\Entity\Product;
use Mockery;
use ReflectionClass;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEmpty;

/**
 * Class PriceListTest.
 *
 * @covers \App\Product\Domain\Entity\PriceList
 */
final class PriceListTest extends TestCase
{
    private PriceList $priceList;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->priceList = new PriceList();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->priceList);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(PriceList::class))
            ->getProperty('id');
        $property->setValue($this->priceList, $expected);
        $this->assertSame($expected, $this->priceList->getId());
    }

    public function testName(): void
    {
        $expected = '42';
        $this->priceList->setName($expected);
        $this->assertSame($expected, $this->priceList->getName());
    }

    public function testPriceOneDay(): void
    {
        $expected = 42;
        $this->priceList->setPriceOneDay($expected);
        $this->assertSame($expected, $this->priceList->getPriceOneDay());
    }

    public function testPriceThreeDays(): void
    {
        $expected = 42;
        $this->priceList->setPriceThreeDays($expected);
        $this->assertSame($expected, $this->priceList->getPriceThreeDays());
    }

    public function testPriceSevenDays(): void
    {
        $expected = 42;
        $this->priceList->setPriceSevenDays($expected);
        $this->assertSame($expected, $this->priceList->getPriceSevenDays());
    }

    public function testProduct(): void
    {
        self::assertEmpty($this->priceList->getProducts());
        $product = Mockery::mock(Product::class);
        $product->shouldReceive('setPriceList')->with($this->priceList);
        $product->shouldReceive('getPriceList')->andReturn($this->priceList);
        $product->shouldReceive('setPriceList')->with(null);
        $this->priceList->addProduct($product);
        self::assertEquals(1, $this->priceList->getProducts()->count());
        $this->priceList->addProduct($product);
        self::assertEquals(1, $this->priceList->getProducts()->count());
        $this->priceList->removeProduct($product);
        assertEmpty($this->priceList->getProducts());
    }
}
