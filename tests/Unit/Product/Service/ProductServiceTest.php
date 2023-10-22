<?php

namespace App\Tests\Unit\Product\Service;

use App\Product\Application\Service\ProductService;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductQtyRepositoryInterface;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\Gender;
use App\Shared\Enum\ProductType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Product\Application\Service\ProductService
 * @covers \App\Product\Domain\Entity\Product
 */
class ProductServiceTest extends TestCase
{
    /**
     * @covers \App\Product\Application\Service\ProductService::retrieveOneByType
     */
    public function testRetrieveOneBicycle(): void
    {
        $product = (new Product())
            ->setName('Bicicletta eBike')
            ->setDescription('Ambara Dara Chi')
            ->setGender(Gender::MAN)
            ->setImage('abcdefg.jpg')
            ->setType(ProductType::BYCICLE)
            ->setBicycleType(BicycleType::EBIKE)
            ->setEnabled(true)
        ;

        $productRepository = $this->createMock(ProductRepositoryInterface::class);
        $productRepository->expects($this->any())
            ->method('findOneBy')
            ->willReturn($product)
            ;
        $productQtyRepository = $this->createMock(ProductQtyRepositoryInterface::class);

        $productService = new ProductService($productRepository, $productQtyRepository);
        $this->assertEquals($product->getName(), $productService->retrieveOneByType(BicycleType::EBIKE)->getName());
    }
}
