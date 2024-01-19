<?php

namespace Tests\Unit\Booking\Domain\Entity;

use App\Booking\Domain\Entity\Booking;
use App\Booking\Domain\Entity\Transaction;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class TransactionTest.
 *
 * @covers \App\Booking\Domain\Entity\Transaction
 */
final class TransactionTest extends TestCase
{
    private Transaction $transaction;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->transaction = new Transaction();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->transaction);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('id');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getId());
    }

    public function testGetTransport(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('transport');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getTransport());
    }

    public function testSetTransport(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('transport');
        $this->transaction->setTransport($expected);
        $this->assertSame($expected, $property->getValue($this->transaction));
    }

    public function testGetAmount(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('amount');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getAmount());
    }

    public function testSetAmount(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('amount');
        $this->transaction->setAmount($expected);
        $this->assertSame($expected, $property->getValue($this->transaction));
    }

    public function testGetLevied(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('levied');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getLevied());
    }

    public function testSetLevied(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('levied');
        $this->transaction->setLevied($expected);
        $this->assertSame($expected, $property->getValue($this->transaction));
    }

    public function testGetTransportId(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('transportId');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getTransportId());
    }

    public function testSetTransportId(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('transportId');
        $this->transaction->setTransportId($expected);
        $this->assertSame($expected, $property->getValue($this->transaction));
    }

    public function testGetTransportStatus(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('transportStatus');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getTransportStatus());
    }

    public function testSetTransportStatus(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('transportStatus');
        $this->transaction->setTransportStatus($expected);
        $this->assertSame($expected, $property->getValue($this->transaction));
    }

    public function testGetTransportDetails(): void
    {
        $expected = [];
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('transportDetails');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getTransportDetails());
    }

    public function testSetTransportDetails(): void
    {
        $expected = [];
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('transportDetails');
        $this->transaction->setTransportDetails($expected);
        $this->assertSame($expected, $property->getValue($this->transaction));
    }

    public function testGetRequestId(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('requestId');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getRequestId());
    }

    public function testSetRequestId(): void
    {
        $expected = '42';
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('requestId');
        $this->transaction->setRequestId($expected);
        $this->assertSame($expected, $property->getValue($this->transaction));
    }

    public function testGetBooking(): void
    {
        $expected = Mockery::mock(Booking::class);
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('booking');
        $property->setValue($this->transaction, $expected);
        $this->assertSame($expected, $this->transaction->getBooking());
    }

    public function testSetBooking(): void
    {
        $expected = Mockery::mock(Booking::class);
        $property = (new ReflectionClass(Transaction::class))
            ->getProperty('booking');
        $this->transaction->setBooking($expected);
        $this->assertSame($expected, $property->getValue($this->transaction));
    }
}
