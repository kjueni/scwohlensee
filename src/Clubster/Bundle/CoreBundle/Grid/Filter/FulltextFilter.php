<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Grid\Filter;

use Sylius\Component\Grid\Data\DataSourceInterface;
use Sylius\Component\Grid\Filtering\FilterInterface;
use Webmozart\Assert\Assert;

class FulltextFilter implements FilterInterface
{
    /**
     * @param DataSourceInterface $dataSource
     * @param string $name
     * @param $data
     * @param array $options
     */
    public function apply(DataSourceInterface $dataSource, string $name, $data, array $options): void
    {
        Assert::keyExists($options, 'properties');
        Assert::allString($options['properties']);

        $expressions = [];

        if ($data['search']) {
            foreach ($options['properties'] as $property) {
                $expressions[] = $dataSource->getExpressionBuilder()->like($property, '%' . $data['search'] . '%');
            }

            $dataSource->restrict($dataSource->getExpressionBuilder()->orX(...$expressions),
                DataSourceInterface::CONDITION_AND);
        }
    }
}
