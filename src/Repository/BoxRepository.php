<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Box;

class BoxRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Box::class);
    }

    /**
     * @param array $params
     * @return Box
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $box = Box::fromArray($params);

        return $box;
    }

    /**
     * @param Box $box
     * @param array $params
     * @return Box
     */
    public function hydrate(Box $box, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'title':
                    $box->setTitle($param);
                    break;
                case 'text':
                    $box->setText($param);
                    break;
            }
        }

        return $box;
    }
}
