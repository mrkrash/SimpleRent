<?php

namespace App\Site\Affiliate\Infrastructure\Repository;

use App\Site\Affiliate\Domain\Entity\Affiliate;
use App\Site\Affiliate\Domain\Repository\AffiliateRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Affiliate>
 *
 * @method Affiliate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affiliate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affiliate[]    findAll()
 * @method Affiliate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffiliateRepository extends ServiceEntityRepository implements AffiliateRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affiliate::class);
    }

    public function save(Affiliate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Affiliate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
