<?php

namespace Tests\Unit\Booking\Domain\Entity;

use App\Booking\Domain\Entity\BookedProduct;
use App\Booking\Domain\Entity\Booking;
use App\Booking\Domain\Entity\Transaction;
use App\Customer\Domain\Entity\Customer;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class BookingTest.
 *
 * @covers \App\Booking\Domain\Entity\Booking
 */
final class BookingTest extends TestCase
{
    private Booking $booking;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->booking = new Booking();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->booking);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Booking::class))
            ->getProperty('id');
        $property->setValue($this->booking, $expected);
        $this->assertSame($expected, $this->booking->getId());
    }

    public function testDateStart(): void
    {
        $expected = Mockery::mock(DateTimeImmutable::class);
        $this->booking->setDateStart($expected);
        $this->assertSame($expected, $this->booking->getDateStart());
    }

    public function testDateEnd(): void
    {
        $expected = Mockery::mock(DateTimeImmutable::class);
        $this->booking->setDateEnd($expected);
        $this->assertSame($expected, $this->booking->getDateEnd());
    }

    public function testNotes(): void
    {
        $expected = '42';
        $this->booking->setNotes($expected);
        $this->assertSame($expected, $this->booking->getNotes());
    }

    public function testCustomer(): void
    {
        $expected = Mockery::mock(Customer::class);
        $this->booking->setCustomer($expected);
        $this->assertSame($expected, $this->booking->getCustomer());
    }

    public function testRate(): void
    {
        $expected = 42;
        $this->booking->setRate($expected);
        $this->assertSame($expected, $this->booking->getRate());
    }

    public function testTransaction(): void
    {
        $expected = Mockery::mock(Transaction::class);
        $this->booking->setTransaction($expected);
        $this->assertSame($expected, $this->booking->getTransaction());
    }

    public function testBookedProduct(): void
    {
        $previous = $this->booking->getBookedProduct()->count();
        $product = Mockery::mock(BookedProduct::class);
        $product->shouldReceive('setBooking')->with($this->booking);
        $product->shouldReceive('getBooking');
        $this->booking->addProduct($product);
        self::assertEquals($previous + 1, $this->booking->getBookedProduct()->count());
        $this->booking->removeProduct($product);
        self::assertEquals($previous, $this->booking->getBookedProduct()->count());
    }
}
