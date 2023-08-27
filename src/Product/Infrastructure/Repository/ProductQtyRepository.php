<?php

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Product\Domain\Repository\ProductQtyRepositoryInterface;
use App\Shared\Enum\ProductSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductQty>
 *
 * @method ProductQty|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductQty|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductQty[]    findAll()
 * @method ProductQty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductQtyRepository extends ServiceEntityRepository implements ProductQtyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductQty::class);
    }

    public function save(ProductQty $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProductQty $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getBySize(Product $product, ProductSize $size): ?ProductQty
    {
        return $this->createQueryBuilder('pq')
            ->where('pq.product = :product')
            ->andWhere('pq.size = :size')
            ->setParameter('product', $product)
            ->setParameter('size', $size)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
