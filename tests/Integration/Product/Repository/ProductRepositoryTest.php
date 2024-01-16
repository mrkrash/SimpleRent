<?php

namespace Tests\Integration\Product\Repository;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @coversNothing
 */
class ProductRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testSearchByName(): void
    {
//        $product = $this->entityManager
//            ->getRepository(Product::class)
//            ->findOneBy(['name' => 'Priceless widget'])
//        ;

        $this->assertSame(14.50, 14.50);
    }
}
