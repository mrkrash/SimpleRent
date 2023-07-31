<?php

namespace App\Customer\Infrastructure\Repository;

use App\Customer\Domain\Entity\Customer;
use App\Customer\Domain\Repository\CustomerRepositoryInterface;
use App\Shared\DTO\CustomerDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository implements CustomerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function save(Customer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Customer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByDto(CustomerDto $customerDto): ?Customer
    {
        $this->createQueryBuilder('c')
            ->where('c.firstname = :fisrtname')
            ->andWhere('c.lastname = :lastname')
            ->andWhere('c.phone = :email')
            ->andWhere('c.email = :email')
            ->setParameter('firstname', $customerDto->getFirstname())
            ->setParameter('lastname', $customerDto->getLastname())
            ->setParameter('email', $customerDto->getEmail())
            ->setParameter('phone', $customerDto->getPhone())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
