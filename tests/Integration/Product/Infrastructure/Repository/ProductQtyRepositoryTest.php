<?php

namespace Tests\Integration\Product\Infrastructure\Repository;

use App\Product\Domain\Entity\PriceList;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Product\Domain\Repository\ProductQtyRepositoryInterface;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\Gender;
use App\Shared\Enum\ProductSize;
use App\Shared\Enum\ProductType;
use App\DataFixtures\PriceListFixture;
use Mockery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Product\Infrastructure\Repository\ProductQtyRepository
 */
class ProductQtyRepositoryTest extends KernelTestCase
{
    private ProductRepositoryInterface $productRepository;
    private ProductQtyRepositoryInterface $productQtyRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->productQtyRepository = $kernel->getContainer()->get('doctrine')->getRepository(ProductQty::class);
        $this->productRepository = $kernel->getContainer()->get('doctrine')->getRepository(Product::class);
    }

    public function testSave(): void
    {
        $product = new Product();
        $product->setName('Product RacingBike Two');
        $product->setDescription('Product Two RacingBike description');
        $product->setImage('imagePath');
        $product->setType(ProductType::BYCICLE);
        $product->setBicycleType(BicycleType::RACINGBIKE);
        $product->setEnabled(false);
        $product->setGender(Gender::WOMAN);
        $product->setOrdering(42);
        $product->setPriceList(
            (new PriceList())
            ->setName('Raaaa')
                ->setPriceOneDay(1)
                ->setPriceThreeDays(3)
                ->setPriceSevenDays(7)
        );

        $previous = count($this->productQtyRepository->findAll());
        $productQty = new ProductQty();
        $productQty->setProduct($product);
        $productQty->setQty(23);
        $productQty->setSize(ProductSize::S36);

        $this->productQtyRepository->save($productQty, true);

        self::assertEquals($previous + 1, count($this->productQtyRepository->findAll()));
    }

    public function testRemove(): void
    {
        $previous = count($this->productQtyRepository->findAll());
        $productQty = $this->productQtyRepository->findOneBy(['size' => ProductSize::S36]);
        $this->productQtyRepository->remove($productQty, true);
        self::assertEquals($previous - 1, count($this->productQtyRepository->findAll()));
    }

    public function testGetBySize(): void
    {
        $product = $this->productRepository->findOneBy(['name' => 'Product Pedals']);
        $productQty = $this->productQtyRepository->getBySize($product, ProductSize::M);

        self::assertInstanceOf(ProductQty::class, $productQty);
        self::assertEquals(7, $productQty->getQty());
    }
}
