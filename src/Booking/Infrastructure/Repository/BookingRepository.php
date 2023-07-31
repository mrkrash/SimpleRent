<?php

namespace App\Booking\Infrastructure\Repository;

use App\Booking\Domain\Entity\Booking;
use App\Booking\Domain\Repository\BookingRepositoryInterface;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository implements BookingRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function checkDates(DateTimeImmutable $start, DateTimeImmutable $stop): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.dateStart BETWEEN :start AND :end')
            ->orWhere('b.dateEnd BETWEEN :start AND :end')
            ->setParameter('start', $start->format('Y-m-d\T00:00:00'))
            ->setParameter('end', $stop->format('Y-m-d\T00:00:00'))
            ->getQuery()
            ->getResult();
    }
}
