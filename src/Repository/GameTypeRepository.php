<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\GameType;

class GameTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameType::class);
    }

    /**
     * @param array $params
     * @return GameType
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $type = GameType::fromArray($params);

        return $type;
    }

    /**
     * @param GameType $type
     * @param array $params
     * @return GameType
     */
    public function hydrate(GameType $type, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $type->setName($param);
                    break;
            }
        }

        return $type;
    }
}
