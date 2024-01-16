<?php

namespace Tests\Integration\Product\Application\Service;

use App\Product\Application\Service\PriceListService;
use App\Product\Domain\Entity\PriceList;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;

/**
 * @covers \App\Product\Application\Service\PriceListService
 * @covers \App\Product\Infrastructure\Repository\PriceListRepository
 */
class PriceListServiceTest extends KernelTestCase
{
    protected PriceListService $priceListService;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->priceListService = new PriceListService(
            $kernel->getContainer()->get('doctrine')->getRepository(PriceList::class)
        );
    }

    public function testFindAll(): void
    {
        $priceLists = $this->priceListService->findAll();
        assertIsArray($priceLists);
        assertInstanceOf(PriceList::class, $priceLists[0]);
    }
}
