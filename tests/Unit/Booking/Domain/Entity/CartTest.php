<?php

namespace Tests\Unit\Booking\Domain\Entity;

use App\Booking\Domain\Entity\Cart;
use App\Booking\Domain\Entity\CartItem;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class CartTest.
 *
 * @covers \App\Booking\Domain\Entity\Cart
 */
final class CartTest extends TestCase
{
    private Cart $cart;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = new Cart();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->cart);
    }

    public function testId(): void
    {
        $expected = 42;
        $this->cart->setId($expected);
        $this->assertSame($expected, $this->cart->getId());
    }

    public function testRate(): void
    {
        $expected = 42;
        $this->cart->setRate($expected);
        $this->assertSame($expected, $this->cart->getRate());
    }

    public function testDateStart(): void
    {
        $expected = Mockery::mock(DateTimeImmutable::class);
        $this->cart->setDateStart($expected);
        $this->assertSame($expected, $this->cart->getDateStart());
    }

    public function testDateEnd(): void
    {
        $expected = Mockery::mock(DateTimeImmutable::class);
        $this->cart->setDateEnd($expected);
        $this->assertSame($expected, $this->cart->getDateEnd());
    }

    public function testValidUntil(): void
    {
        $expected = Mockery::mock(DateTimeImmutable::class);
        $this->cart->setValidUntil($expected);
        $this->assertSame($expected, $this->cart->getValidUntil());
    }

    public function testCartItems(): void
    {
        $previous = $this->cart->getCartItems()->count();
        $item = Mockery::mock(CartItem::class);
        $item->shouldReceive('setCart')->with($this->cart);
        $item->shouldReceive('getCart');
        $this->cart->addCartItem($item);
        self::assertEquals($previous + 1, $this->cart->getCartItems()->count());
        $this->cart->removeCartItem($item);
        self::assertEquals($previous, $this->cart->getCartItems()->count());
    }

    public function testGetTotalItemsCount(): void
    {
        $item1 = Mockery::mock(CartItem::class);
        $item1->shouldReceive('getQty')->andReturn(3);
        $item1->shouldReceive('setCart')->with($this->cart);
        $this->cart->addCartItem($item1);
        $item2 = Mockery::mock(CartItem::class);
        $item2->shouldReceive('getQty')->andReturn(4);
        $item2->shouldReceive('setCart')->with($this->cart);
        $this->cart->addCartItem($item2);
        self::assertEquals(7, $this->cart->getTotalItemsCount());
    }

    public function testJsonSerialize(): void
    {
        $this->cart->setId(42);
        $this->cart->setValidUntil(Mockery::mock(DateTimeImmutable::class));
        $item1 = Mockery::mock(CartItem::class);
        $item1->shouldReceive('getQty')->andReturn(3);
        $item1->shouldReceive('setCart')->with($this->cart);
        $this->cart->addCartItem($item1);
        $this->cart->setRate(42);
        self::assertEquals([
            'id' => $this->cart->getId(),
            'validUntil' => $this->cart->getValidUntil(),
            'count' => $this->cart->getTotalItemsCount(),
            'rate' => $this->cart->getRate(),
        ], $this->cart->jsonSerialize());
    }
}
