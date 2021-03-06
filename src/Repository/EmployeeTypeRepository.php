<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\EmployeeType;

class EmployeeTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EmployeeType::class);
    }

    /**
     * @param array $params
     * @return EmployeeType
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $type = EmployeeType::fromArray($params);

        return $type;
    }

    /**
     * @param EmployeeType $type
     * @param array $params
     * @return EmployeeType
     */
    public function hydrate(EmployeeType $type, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $type->setName($param);
                    break;

                case 'executive':
                    $type->setExecutive($param);
                    break;

                case 'sort_index':
                    $type->setSortIndex($param);
                    break;
            }
        }

        return $type;
    }
}
