<?php

namespace App\Booking\Infrastructure\Repository;

use App\Booking\Domain\Entity\Cart;
use App\Booking\Domain\Entity\CartItem;
use App\Booking\Domain\Repository\CartItemRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartItem>
 *
 * @method CartItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartItem[]    findAll()
 * @method CartItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartItemRepository extends ServiceEntityRepository implements CartItemRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartItem::class);
    }

    /**
     * @param Cart $cart
     * @param int $productId
     * @param int $productQtyId
     * @return CartItem|null
     * @throws NonUniqueResultException
     */
    public function getFromCart(Cart $cart, int $productId, int $productQtyId): ?CartItem
    {
        return $this->createQueryBuilder('ci')
            ->where('ci.cart = :cart')
            ->andWhere('ci.productId = :productId')
            ->andWhere('ci.size = :productQtyId')
            ->setParameter('cart', $cart)
            ->setParameter('productId', $productId)
            ->setParameter('productQtyId', $productQtyId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(CartItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CartItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
