<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Repository\ORM;

use Doctrine\ORM\QueryBuilder;

interface FilterAwareRepositoryInterface
{
    /**
     * @param array $joins
     * @param mixed ...$arguments
     * @return QueryBuilder
     */
    public function createListQueryBuilder(array $joins = [], ...$arguments): QueryBuilder;

}
