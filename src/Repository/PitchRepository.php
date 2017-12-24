<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Pitch;

class PitchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pitch::class);
    }

    /**
     * @param array $params
     * @return Pitch
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $pitch = Pitch::fromArray($params);

        return $pitch;
    }

    /**
     * @param Pitch $position
     * @param array $params
     * @return Pitch
     */
    public function hydrate(Pitch $pitch, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $pitch->setName($param);
                    break;
                case  'address':
                    $pitch->setAddress($param);
                    break;
                case  'zip_code':
                    $pitch->setZipCode($param);
                    break;
                case  'place':
                    $pitch->setPlace($param);
                    break;
            }
        }

        return $pitch;
    }
}
