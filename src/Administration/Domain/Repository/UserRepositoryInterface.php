<?php

namespace App\Administration\Domain\Repository;

use App\Administration\Domain\Entity\User;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface UserRepositoryInterface
{
    public function save(User $entity, bool $flush = false): void;
    public function remove(User $entity, bool $flush = false): void;
}