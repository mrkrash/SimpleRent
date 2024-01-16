<?php

namespace Tests\Integration\Product\Application\Service;

use App\Product\Application\Service\ProductService;
use App\Product\Domain\Entity\PriceList;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\Gender;
use App\Shared\Enum\ProductSize;
use App\Shared\Enum\ProductType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;

/**
 * @covers \App\Product\Application\Service\ProductService
 * @covers \App\Product\Domain\Entity\PriceList
 * @covers \App\Product\Domain\Entity\Product
 * @covers \App\Product\Domain\Entity\ProductQty
 * @covers \App\Product\Infrastructure\Repository\ProductRepository
 */
class ProductServiceTest extends KernelTestCase
{
    protected ProductService $productService;
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->productService = new ProductService(
            $kernel->getContainer()->get('doctrine')->getRepository(Product::class),
            $kernel->getContainer()->get('doctrine')->getRepository(ProductQty::class)
        );
    }

    public function testRetrieveOneByType(): int
    {
        $product = $this->productService->retrieveOneByType(BicycleType::EBIKE);
        self::assertInstanceOf(Product::class, $product);
        self::assertEquals(Gender::MAN, $product->getGender());
        self::assertEquals(2, $product->getQty());

        return $product->getId();
    }

    /**
     * @depends testRetrieveOneByType
     */
    public function testRetrieveById(int $id): Product
    {
        $product = $this->productService->retrieveById($id);
        self::assertInstanceOf(Product::class, $product);
        self::assertEquals(Gender::MAN, $product->getGender());
        self::assertEquals(2, $product->getQty());

        return $product;
    }

    /**
     * @depends testRetrieveById
     */
    public function testRetrieveQtyBySize(Product $product): int
    {
        $productQty = $this->productService->retrieveQtyBySize($product, ProductSize::XL);
        self::assertInstanceOf(ProductQty::class, $productQty);
        assertEquals(0, $productQty->getQty());

        $productQty = $this->productService->retrieveQtyBySize($product, ProductSize::L);
        self::assertInstanceOf(ProductQty::class, $productQty);
        assertEquals(2, $productQty->getQty());

        return $productQty->getId();
    }

    /**
     * @depends testRetrieveQtyBySize
     */
    public function testSizeInHumanReadable(int $id): void
    {
        assertEquals(ProductSize::L->value, $this->productService->retrieveSizeHumanReadable($id));
    }

    public function testRetrieveByType(): void
    {
        $products = $this->productService->retrieveByType(ProductType::BYCICLE);
        self::assertIsArray($products);
        self::assertInstanceOf(Product::class, $products[0]);
    }

    public function testRetrieveBiCycleAvailableByType(): void
    {
        $products = $this->productService->retrieveBicycleAvailableByType(BicycleType::GRAVEL);
        self::assertIsArray($products);
        self::assertInstanceOf(Product::class, $products[0]);
    }

    public function testAccessoryByType(): void
    {
        $accessories = $this->productService->retrieveAccessoryDtoByType();
        assertIsArray($accessories);
        assertInstanceOf(Product::class, $accessories[0]);
    }

    /**
     * @depends testRetrieveById
     */
    public function testRetrieveQty(Product $product): void
    {
        assertEquals(2, $this->productService->retrieveQty($product)['L']);
    }

    public function testRemove(): void
    {
        $product = $this->productService->retrieveOneByType(BicycleType::RACINGBIKE);
        $this->productService->remove($product);
        self::assertNull($this->productService->retrieveOneByType(BicycleType::RACINGBIKE));
    }

    public function testPersist(): void
    {
        $product = new Product();
        $product->setName('Product Aaaargh');
        $product->setDescription('Product Aaaargh description');
        $product->setImage('imagePath');
        $product->setType(ProductType::BYCICLE);
        $product->setBicycleType(BicycleType::RACINGBIKE);
        $product->setEnabled(false);
        $product->setGender(Gender::UNISEX);
        $product->setOrdering(20);
        $product->setPriceList(
            (new PriceList())
                ->setName('Aaargh')
                ->setPriceSevenDays(7)
                ->setPriceThreeDays(3)
                ->setPriceOneDay(1)
        );
        $this->productService->persist($product);
        assertInstanceOf(Product::class, $this->productService->retrieveOneByType(BicycleType::RACINGBIKE));
    }
}
