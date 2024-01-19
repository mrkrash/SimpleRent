<?php

namespace Tests\Unit\Booking\Domain\Entity;

use App\Booking\Domain\Entity\Cart;
use App\Booking\Domain\Entity\CartItem;
use Mockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use function PHPUnit\Framework\assertSame;

/**
 * Class CartItemTest.
 *
 * @covers \App\Booking\Domain\Entity\CartItem
 */
final class CartItemTest extends TestCase
{
    private CartItem $cartItem;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->cartItem = new CartItem();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->cartItem);
    }

    public function testId(): void
    {
        $expected = 42;
        $this->cartItem->setId($expected);
        $this->assertSame($expected, $this->cartItem->getId());
    }

    public function testCart(): void
    {
        $expected = Mockery::mock(Cart::class);
        $this->cartItem->setCart($expected);
        $this->assertSame($expected, $this->cartItem->getCart());
    }

    public function testProductId(): void
    {
        $expected = 42;
        $this->cartItem->setProductId($expected);
        $this->assertSame($expected, $this->cartItem->getProductId());
    }

    public function testAccessoryId(): void
    {
        $expected = 42;
        $this->cartItem->setAccessoryId($expected);
        $this->assertSame($expected, $this->cartItem->getAccessoryId());
    }

    public function testQty(): void
    {
        $expected = 42;
        $this->cartItem->setQty($expected);
        $this->assertSame($expected, $this->cartItem->getQty());
    }

    public function testSize(): void
    {
        $expected = '42';
        $this->cartItem->setSize($expected);
        $this->assertSame($expected, $this->cartItem->getSize());
    }

    public function testJsonSerialize(): void
    {
        $this->cartItem->setProductId(42);
        $this->cartItem->setQty(42);
        $this->cartItem->setSize('L');
        assertSame([
            'productId' => $this->cartItem->getProductId(),
            'qty' => $this->cartItem->getQty(),
            'size' => $this->cartItem->getSize(),
        ], $this->cartItem->jsonSerialize());
    }
}
