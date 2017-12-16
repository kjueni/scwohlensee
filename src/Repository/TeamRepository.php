<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Team;

class TeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * @param array $params
     * @return Team
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $requiredParams = array(
            'name',
            'description',
            'league'
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf(
                        'Required parameter was not provided: "%s"',
                        $param
                    )
                );
            }
        }

        $team = new Team(
            $params['name'],
            $params['description'],
            $params['league']
        );

        return $team;
    }

    /**
     * @param Team $team
     * @param array $params
     * @return Team
     */
    public function hydrate(Team $team, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case 'name':
                    $team->setName($param);
                    break;
                case 'description':
                    $team->setDescription($param);
                    break;
                case 'league':
                    $team->setLeague($param);
                    break;
            }
        }

        return $team;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('t')
            ->where('t.something = :value')->setParameter('value', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
