<?php

namespace Tests\Unit\Product\Domain\Entity;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Shared\Enum\ProductSize;
use Mockery;
use ReflectionClass;
use PHPUnit\Framework\TestCase;

/**
 * Class ProductQtyTest.
 *
 * @covers \App\Product\Domain\Entity\ProductQty
 */
final class ProductQtyTest extends TestCase
{
    private ProductQty $productQty;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->productQty = new ProductQty();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->productQty);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(ProductQty::class))
            ->getProperty('id');
        $property->setValue($this->productQty, $expected);
        $this->assertSame($expected, $this->productQty->getId());
    }

    public function testSize(): void
    {
        $expected = ProductSize::L;
        $this->productQty->setSize($expected);
        $this->assertSame($expected, $this->productQty->getSize());
    }

    public function testQty(): void
    {
        $expected = 42;
        $this->productQty->setQty($expected);
        $this->assertSame($expected, $this->productQty->getQty());
    }

    public function testProduct(): void
    {
        $expected = Mockery::mock(Product::class);
        $this->productQty->setProduct($expected);
        $this->assertSame($expected, $this->productQty->getProduct());
    }
}
