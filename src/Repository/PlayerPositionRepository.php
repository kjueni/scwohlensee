<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\PlayerPosition;

class PlayerPositionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlayerPosition::class);
    }

    /**
     * @param array $params
     * @return PlayerPosition
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $position = PlayerPosition::fromArray($params);

        return $position;
    }

    /**
     * @param PlayerPosition $position
     * @param array $params
     * @return PlayerPosition
     */
    public function hydrate(PlayerPosition $position, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case 'name':
                    $position->setName($param);
                    break;
                case 'sort_index':
                    $position->setSortIndex($param);
                    break;
            }
        }

        return $position;
    }
}
