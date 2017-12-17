<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\NewsType;

class NewsTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NewsType::class);
    }

    /**
     * @param array $params
     * @return NewsType
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $type = NewsType::fromArray($params);

        return $type;
    }

    /**
     * @param NewsType $type
     * @param array $params
     * @return NewsType
     */
    public function hydrate(NewsType $type, $params)
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
