<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\NavigationEntry;

class NavigationEntryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NavigationEntry::class);
    }

    /**
     * @param array $params
     * @return NavigationEntry
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $entry = NavigationEntry::fromArray($params);

        return $entry;
    }

    /**
     * @param NavigationEntry $entry
     * @param array $params
     * @return NavigationEntry
     */
    public function hydrate(NavigationEntry $entry, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'title':
                    $entry->setTitle($param);
                    break;
                case  'url':
                    $entry->setUrl($param);
                    break;
                case  'sort_index':
                    $entry->setSortIndex($param);
                    break;
                case  'parent':
                    $entry->setParent($param);
                    break;
                case  'boxes':
                    $entry->setBoxes($param);
                    break;
            }
        }

        return $entry;
    }
}
