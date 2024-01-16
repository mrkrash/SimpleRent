<?php

namespace DataFixtures;

use App\Product\Domain\Entity\PriceList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PriceListFixture extends Fixture
{
    public const ONE = 'pricelist-one';
    public const TWO = 'pricelist-two';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $priceList = new PriceList();
        $priceList->setName('PriceList One');
        $priceList->setPriceOneDay(24);
        $priceList->setPriceThreeDays(42);
        $priceList->setPriceSevenDays(422);
        $manager->persist($priceList);
        $this->setReference(self::ONE, $priceList);

        unset($priceList);
        $priceList = new PriceList();
        $priceList->setName('PriceList Two');
        $priceList->setPriceOneDay(42);
        $priceList->setPriceThreeDays(24);
        $priceList->setPriceSevenDays(224);
        $manager->persist($priceList);
        $this->setReference(self::TWO, $priceList);

        $manager->flush();
    }
}
