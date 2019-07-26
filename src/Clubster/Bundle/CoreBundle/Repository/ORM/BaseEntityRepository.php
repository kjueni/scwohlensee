<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Repository\ORM;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Webmozart\Assert\Assert;

class BaseEntityRepository extends EntityRepository implements FilterAwareRepositoryInterface
{
    /**
     * @param array $joins
     * @param mixed ...$arguments
     * @return QueryBuilder
     */
    public function createListQueryBuilder(array $joins = [], ...$arguments): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o');

        Assert::allString($joins);

        foreach ($joins as $join) {
            $queryBuilder->join('o.' . $join, $join);
        }

        return $queryBuilder;
    }
}

