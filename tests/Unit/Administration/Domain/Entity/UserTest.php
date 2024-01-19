<?php

namespace Tests\Unit\Administration\Domain\Entity;

use App\Administration\Domain\Entity\User;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class UserTest.
 *
 * @covers \App\Administration\Domain\Entity\User
 */
final class UserTest extends TestCase
{
    private User $user;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->user = new User();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->user);
    }

    public function testGetId(): void
    {
        $expected = 42;
        $property = (new ReflectionClass(User::class))
            ->getProperty('id');
        $property->setValue($this->user, $expected);
        $this->assertSame($expected, $this->user->getId());
    }

    public function testUsername(): void
    {
        $expected = 'pippo';
        $this->user->setUsername($expected);
        $this->assertSame($expected, $this->user->getUsername());
    }

    public function testGetUserIdentifier(): void
    {
        $expected = 'pippo';
        $this->user->setUsername($expected);
        $this->assertSame($expected, $this->user->getUserIdentifier());
    }

    public function testRoles(): void
    {
        $expected = ['ROLE_USER'];
        $this->user->setRoles($expected);
        $this->assertSame($expected, $this->user->getRoles());
    }

    public function testPassword(): void
    {
        $expected = '42secure!@';
        $this->user->setPassword($expected);
        $this->assertSame($expected, $this->user->getPassword());
    }
}
