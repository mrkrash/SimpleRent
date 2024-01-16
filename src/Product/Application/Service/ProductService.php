<?php

declare(strict_types=1);

namespace App\Product\Application\Service;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Product\Domain\Repository\ProductQtyRepositoryInterface;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\ProductSize;
use App\Shared\Enum\ProductType;
use Symfony\Component\Form\FormInterface;

final class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductQtyRepositoryInterface $qtyRepository,
    ) {
    }

    public function persist(Product $product): void
    {
        $this->productRepository->save($product, true);
    }

    public function retrieveById(int $idx): ?Product
    {
        return $this->productRepository->find($idx);
    }

    public function retrieveSizeHumanReadable(int $idx): ?string
    {
        return $this->qtyRepository->find($idx)->getSize()->value;
    }

    public function retrieveOneByType(BicycleType $type): ?Product
    {
        return $this->productRepository->findOneBy(['bicycleType' => $type]);
    }

    /**
     * @return Product[]
     */
    public function retrieveByType(ProductType $type): array
    {
        return $this->productRepository->findBy(['type' => $type]);
    }

//    /**
//     * @return Product[]
//     */
//    public function retrieveBicycleByType(BicycleType $type, bool $enabled = false): array
//    {
//        $criteria = ['type' => ProductType::BYCICLE, 'bicycleType' => $type];
//        if ($enabled) {
//            $criteria['enabled'] = true;
//        }
//        return $this->productRepository->findBy($criteria);
//    }

    /**
     * @return Product[]
     */
    public function retrieveBicycleAvailableByType(BicycleType $bicycleType): array
    {
        return $this->productRepository->findAllSizeWithQtyByType(ProductType::BYCICLE, $bicycleType);
    }

    /**
     * @return Product[]
     */
    public function retrieveAccessoryDtoByType(): array
    {
        return $this->productRepository->findAllSizeWithQtyByType(ProductType::ACCESSORY);
    }

    public function retrieveQtyBySize(Product $product, ProductSize $size): ProductQty
    {
        $productQty = $this->qtyRepository->getBySize($product, $size);
        if (null === $productQty) {
            $productQty = (new ProductQty())->setProduct($product)->setSize($size)->setQty(0);
        }

        return $productQty;
    }

    public function handleQty(Product $product, FormInterface $form): Product
    {
        if (isset($form['sizeXS'])) {
            $product->addProductQty(
                $this->retrieveQtyBySize(
                    product: $product,
                    size: ProductSize::XS
                )->setQty((int) $form['sizeXS']->getData())
            );
        }
        if (isset($form['sizeS'])) {
            $product->addProductQty(
                $this->retrieveQtyBySize(
                    product: $product,
                    size: ProductSize::S
                )->setQty((int) $form['sizeS']->getData())
            );
        }
        if (isset($form['sizeM'])) {
            $product->addProductQty(
                $this->retrieveQtyBySize(
                    product: $product,
                    size: ProductSize::M
                )->setQty((int) $form['sizeM']->getData())
            );
        }
        if (isset($form['sizeL'])) {
            $product->addProductQty(
                $this->retrieveQtyBySize(
                    product: $product,
                    size: ProductSize::L
                )->setQty((int) $form['sizeL']->getData())
            );
        }
        if (isset($form['sizeXL'])) {
            $product->addProductQty(
                $this->retrieveQtyBySize(
                    product: $product,
                    size: ProductSize::XL
                )->setQty((int) $form['sizeXL']->getData())
            );
        }

        return $product;
    }

    public function retrieveQty(Product $product): array
    {
        $qty = [
            'XS' => 0,
            'S' => 0,
            'M' => 0,
            'L' => 0,
            'XL' => 0,
            'S36' => 0,
            'S37' => 0,
            'S38' => 0,
            'S39' => 0,
            'S40' => 0,
            'S41' => 0,
            'S42' => 0,
            'S43' => 0,
            'S44' => 0,
            'S45' => 0,
            'S46' => 0,
            'S47' => 0,
        ];
        foreach ($this->qtyRepository->findBy(['product' => $product]) as $productQty) {
            match ($productQty->getSize()) {
                ProductSize::XS => $qty['XS'] = $productQty->getQty(),
                ProductSize::S => $qty['S'] = $productQty->getQty(),
                ProductSize::M => $qty['M'] = $productQty->getQty(),
                ProductSize::L => $qty['L'] = $productQty->getQty(),
                ProductSize::XL => $qty['XL'] = $productQty->getQty(),
                ProductSize::S36 => $qty['S36'] = $productQty->getQty(),
                ProductSize::S37 => $qty['S37'] = $productQty->getQty(),
                ProductSize::S38 => $qty['S38'] = $productQty->getQty(),
                ProductSize::S39 => $qty['S39'] = $productQty->getQty(),
                ProductSize::S40 => $qty['S40'] = $productQty->getQty(),
                ProductSize::S41 => $qty['S41'] = $productQty->getQty(),
                ProductSize::S42 => $qty['S42'] = $productQty->getQty(),
                ProductSize::S43 => $qty['S43'] = $productQty->getQty(),
                ProductSize::S44 => $qty['S44'] = $productQty->getQty(),
                ProductSize::S45 => $qty['S45'] = $productQty->getQty(),
                ProductSize::S46 => $qty['S46'] = $productQty->getQty(),
                ProductSize::S47 => $qty['S47'] = $productQty->getQty(),
            };
        }

        return $qty;
    }

    public function remove(Product $product): void
    {
        $this->productRepository->remove($product, true);
    }
}
