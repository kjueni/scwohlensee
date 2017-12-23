<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Ad;

class AdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    /**
     * @param array $params
     * @return Ad
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $ad = Ad::fromArray($params);

        return $ad;
    }

    /**
     * @param Ad $ad
     * @param array $params
     * @return Ad
     */
    public function hydrate(Ad $ad, $params)
    {
        foreach ($params as $key => $param) {

            switch ($key) {
                case  'description':
                    $ad->setDescription($param);
                    break;
                case  'address':
                    $ad->setAddress($param);
                    break;
                case 'picture_url':
                    $ad->setPictureUrl($param);
                    break;
                case 'url':
                    $ad->setUrl($param);
                    break;
                case 'types':
                    $ad->setTypes($param);
                    break;
                case 'teams':
                    $ad->setTeams($param);
                    break;
            }
        }

        return $ad;
    }
}
