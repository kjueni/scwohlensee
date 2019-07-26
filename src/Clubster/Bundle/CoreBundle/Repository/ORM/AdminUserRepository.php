<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Repository\ORM;

use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;

class AdminUserRepository extends BaseEntityRepository implements
    FilterAwareRepositoryInterface,
    UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findOneByEmail(string $email): ?UserInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.emailCanonical = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
