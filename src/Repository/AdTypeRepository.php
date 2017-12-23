<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\AdType;

class AdTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdType::class);
    }

    /**
     * @param array $params
     * @return AdType
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $type = AdType::fromArray($params);

        return $type;
    }

    /**
     * @param AdType $type
     * @param array $params
     * @return AdType
     */
    public function hydrate(AdType $type, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $type->setName($param);
                    break;
                case  'show_count':
                    $type->setShowCount($param);
                    break;
                case 'width':
                    $type->setWidth($param);
                    break;
                case 'height':
                    $type->setHeight($param);
                    break;
            }
        }

        return $type;
    }
}
