<?php

namespace Tests\Integration\Product\Infrastructure\Repository;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Product\Infrastructure\Repository\ProductRepository
 */
class ProductRepositoryTest extends KernelTestCase
{
    private ?ProductRepositoryInterface $productRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->productRepository = $kernel->getContainer()->get('doctrine')->getRepository(Product::class);
    }

    public function testSearchByName(): void
    {
        $this->assertSame(
            'Product One eBike description',
            $this->productRepository->findOneBy(['name' => 'Product eBike One'])->getDescription()
        );
    }
}
