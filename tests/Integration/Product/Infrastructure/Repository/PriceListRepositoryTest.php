<?php

namespace Tests\Integration\Product\Infrastructure\Repository;

use App\Product\Domain\Entity\PriceList;
use App\Product\Domain\Repository\PriceListRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\Product\Infrastructure\Repository\PriceListRepository
 */
class PriceListRepositoryTest extends KernelTestCase
{
    protected PriceListRepositoryInterface $priceListRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->priceListRepository = $kernel->getContainer()->get('doctrine')->getRepository(PriceList::class);
    }

    public function testSave(): void
    {
        $previous = count($this->priceListRepository->findAll());
        $priceList = new PriceList();
        $priceList->setName('PriceList One');
        $priceList->setPriceOneDay(23);
        $priceList->setPriceThreeDays(43);
        $priceList->setPriceSevenDays(433);

        $this->priceListRepository->save($priceList, true);

        self::assertEquals($previous + 1, count($this->priceListRepository->findAll()));
    }

    public function testRemove(): void
    {
        $previous = count($this->priceListRepository->findAll());
        $priceList = $this->priceListRepository->findOneBy(['name' => 'PriceList One']);
        $this->priceListRepository->remove($priceList, true);
        self::assertEquals($previous - 1, count($this->priceListRepository->findAll()));
    }
}
