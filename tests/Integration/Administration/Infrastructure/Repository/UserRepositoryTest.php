<?php

namespace Tests\Integration\Administration\Infrastructure\Repository;

use App\Administration\Domain\Entity\User;
use App\Administration\Domain\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Administration\Infrastructure\Repository\UserRepository
 */
class UserRepositoryTest extends KernelTestCase
{
    private UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->userRepository = $kernel->getContainer()->get('doctrine')->getRepository(User::class);
    }

    public function testSaveNewUser(): void
    {
        $this->userRepository->save(
            (new User())->setUsername('pippo')->setPassword('123stella')->setRoles(['ROLE_USER']),
            true
        );
        self::assertInstanceOf(User::class, $this->userRepository->findOneBy(['username' => 'pippo']));
    }

    /**
     * @depends testSaveNewUser
     */
    public function testRemoveUser(): void
    {
        $user = $this->userRepository->findOneBy(['username' => 'pippo']);
        $this->userRepository->remove($user, true);
        self::assertNull($this->userRepository->findOneBy(['username' => 'pippo']));
    }
}
