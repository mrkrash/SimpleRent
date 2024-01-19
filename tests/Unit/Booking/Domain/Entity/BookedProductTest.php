<?php

namespace Tests\Unit\Booking\Domain\Entity;

use App\Booking\Domain\Entity\BookedProduct;
use App\Booking\Domain\Entity\Booking;
use App\Product\Domain\Entity\Product;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class BookedProductTest.
 *
 * @covers \App\Booking\Domain\Entity\BookedProduct
 */
final class BookedProductTest extends TestCase
{
    private BookedProduct $bookedProduct;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->bookedProduct = new BookedProduct();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->bookedProduct);
    }

    public function testId(): void
    {
        $expected = 42;
        $this->bookedProduct->setId($expected);
        $this->assertSame($expected, $this->bookedProduct->getId());
    }

    public function testQty(): void
    {
        $expected = 42;
        $this->bookedProduct->setQty($expected);
        $this->assertSame($expected, $this->bookedProduct->getQty());
    }

    public function testSize(): void
    {
        $expected = '42';
        $this->bookedProduct->setSize($expected);
        $this->assertSame($expected, $this->bookedProduct->getSize());
    }

    public function testBooking(): void
    {
        $expected = Mockery::mock(Booking::class);
        $this->bookedProduct->setBooking($expected);
        $this->assertSame($expected, $this->bookedProduct->getBooking());
    }

    public function testProduct(): void
    {
        $expected = Mockery::mock(Product::class);
        $this->bookedProduct->setProduct($expected);
        $this->assertSame($expected, $this->bookedProduct->getProduct());
    }
}
