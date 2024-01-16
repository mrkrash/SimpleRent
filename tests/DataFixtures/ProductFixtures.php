<?php

namespace DataFixtures;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\Gender;
use App\Shared\Enum\ProductSize;
use App\Shared\Enum\ProductType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public const ONE = 'bike-one';
    public const TWO = 'bike-two';
    public const THREE = 'bike-three';
    public const FOUR = 'bike-four';
    public const PEDALS = 'pedals';
    public const HELMET = 'helmet';


    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setPriceList($this->getReference(PriceListFixture::ONE));
        $product->setName('Product eBike One');
        $product->setDescription('Product One eBike description');
        $product->setImage('imagePath');
        $product->setType(ProductType::BYCICLE);
        $product->setBicycleType(BicycleType::EBIKE);
        $product->setEnabled(true);
        $product->setGender(Gender::MAN);
        $product->setOrdering(24);
        $product->addProductQty(
            (new ProductQty())
                ->setQty(2)
                ->setSize(ProductSize::L)
        );
        $manager->persist($product);
        $this->setReference(self::ONE, $product);

        unset($product);
        $product = new Product();
        $product->setPriceList($this->getReference(PriceListFixture::ONE));
        $product->setName('Product Gravel One');
        $product->setDescription('Product One Gravel description');
        $product->setImage('imagePath');
        $product->setType(ProductType::BYCICLE);
        $product->setBicycleType(BicycleType::GRAVEL);
        $product->setEnabled(true);
        $product->setGender(Gender::WOMAN);
        $product->setOrdering(124);
        $product->addProductQty(
            (new ProductQty())
                ->setQty(2)
                ->setSize(ProductSize::M)
        );
        $manager->persist($product);
        $this->setReference(self::TWO, $product);

        unset($product);
        $product = new Product();
        $product->setPriceList($this->getReference(PriceListFixture::TWO));
        $product->setName('Product MountainBike One');
        $product->setDescription('Product One MountainBike description');
        $product->setImage('imagePath');
        $product->setType(ProductType::BYCICLE);
        $product->setBicycleType(BicycleType::MOUNTAINBIKE);
        $product->setEnabled(true);
        $product->setGender(Gender::MAN);
        $product->setOrdering(4);
        $product->addProductQty(
            (new ProductQty())
                ->setQty(3)
                ->setSize(ProductSize::S)
        );
        $manager->persist($product);
        $this->setReference(self::THREE, $product);

        unset($product);
        $product = new Product();
        $product->setPriceList($this->getReference(PriceListFixture::TWO));
        $product->setName('Product RacingBike One');
        $product->setDescription('Product One RacingBike description');
        $product->setImage('imagePath');
        $product->setType(ProductType::BYCICLE);
        $product->setBicycleType(BicycleType::RACINGBIKE);
        $product->setEnabled(true);
        $product->setGender(Gender::WOMAN);
        $product->setOrdering(42);
        $product->addProductQty(
            (new ProductQty())
                ->setQty(4)
                ->setSize(ProductSize::L)
        );
        $manager->persist($product);
        $this->setReference(self::FOUR, $product);

        unset($product);
        $product = new Product();
        $product->setPriceList($this->getReference(PriceListFixture::TWO));
        $product->setName('Product Pedals');
        $product->setDescription('Product Pedals description');
        $product->setImage('imagePath');
        $product->setType(ProductType::ACCESSORY);
        $product->setEnabled(true);
        $product->setGender(Gender::WOMAN);
        $product->setOrdering(420);
        $product->addProductQty(
            (new ProductQty())
                ->setQty(7)
                ->setSize(ProductSize::M)
        );
        $manager->persist($product);
        $this->setReference(self::PEDALS, $product);

        unset($product);
        $product = new Product();
        $product->setPriceList($this->getReference(PriceListFixture::TWO));
        $product->setName('Product Helmet');
        $product->setDescription('Product Helmet description');
        $product->setImage('imagePath');
        $product->setType(ProductType::ACCESSORY);
        $product->setEnabled(true);
        $product->setGender(Gender::UNISEX);
        $product->setOrdering(421);
        $product->addProductQty(
            (new ProductQty())
                ->setQty(9)
                ->setSize(ProductSize::S41)
        );
        $manager->persist($product);
        $this->setReference(self::PEDALS, $product);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PriceListFixture::class
        ];
    }
}
