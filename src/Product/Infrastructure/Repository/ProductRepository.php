<?php

namespace App\Product\Infrastructure\Repository;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Entity\ProductQty;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\DTO\ProductDto;
use App\Shared\Enum\BicycleType;
use App\Shared\Enum\ProductType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findEnabled(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.enabled = :val')
            ->setParameter('val', true)
            ->orderBy('p.ordering', 'ASC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllSizeWithQtyByType(ProductType $type, ?BicycleType $bicycleType = null): array
    {
        $qbr = $this->createQueryBuilder('p')
            //->select(sprintf('NEW %s(p.id, p.name, p.image, pq.size, pq.qty)', ProductDto::class))
            ->leftJoin('p.productQty', 'pq')
            ->where('p.enabled = true')
            ->andWhere('p.type = :type')
            ->setParameter('type', $type);
        if (null !== $bicycleType) {
            $qbr->andWhere('p.bicycleType = :bicycleType')->setParameter('bicycleType', $bicycleType);
        }

        return $qbr->getQuery()
            //->setFetchMode(ProductQty::class, 'productQty', ClassMetadataInfo::FETCH_EAGER)
            ->getResult();
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?Product
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
