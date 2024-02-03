<?php

namespace Tests\Unit\Customer\Domain\Entity;

use App\Booking\Domain\Entity\Booking;
use App\Customer\Domain\Entity\Customer;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class CustomerTest.
 *
 * @covers \App\Customer\Domain\Entity\Customer
 */
final class CustomerTest extends TestCase
{
    private Customer $customer;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = new Customer();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->customer);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Customer::class))
            ->getProperty('id');
        $property->setValue($this->customer, $expected);
        $this->assertSame($expected, $this->customer->getId());
    }

    public function testFirstname(): void
    {
        $expected = 'pippo';
        $this->customer->setFirstname($expected);
        $this->assertSame($expected, $this->customer->getFirstname());
    }

    public function testLastname(): void
    {
        $expected = 'pluto';
        $this->customer->setLastname($expected);
        $this->assertSame($expected, $this->customer->getLastname());
    }

    public function testEmail(): void
    {
        $expected = 'pippo@pluto.local';
        $this->customer->setEmail($expected);
        $this->assertSame($expected, $this->customer->getEmail());
    }

    public function testPhone(): void
    {
        $expected = '429996667';
        $this->customer->setPhone($expected);
        $this->assertSame($expected, $this->customer->getPhone());
    }

    public function testNewsletter(): void
    {
        $this->customer->setNewsletter(true);
        $this->assertTrue($this->customer->getNewsletter());
    }

    public function testPrivacy(): void
    {
        $this->customer->setPrivacy(true);
        $this->assertTrue($this->customer->getPrivacy());
    }

    public function testBooking(): void
    {
        $previous = $this->customer->getBookings()->count();
        $booking = Mockery::mock(Booking::class);
        $booking->shouldReceive('setCustomer')->with($this->customer);
        $booking->shouldReceive('getCustomer');
        $this->customer->addBooking($booking);
        self::assertEquals($previous + 1, $this->customer->getBookings()->count());
        $this->customer->removeBooking($booking);
        self::assertEquals($previous, $this->customer->getBookings()->count());
    }
}
