<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\TrainingSession;

class TrainingSessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrainingSession::class);
    }

    /**
     * @param array $params
     * @return TrainingSession
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $session = TrainingSession::fromArray($params);

        return $session;
    }

    /**
     * @param TrainingSession $session
     * @param array $params
     * @return TrainingSession
     */
    public function hydrate(TrainingSession $session, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'weekday':
                    $session->setWeekday($param);
                    break;
                case  'starts_on':
                    $session->setStartsOn($param);
                    break;
                case  'ends_on':
                    $session->setEndsOn($param);
                    break;
                case 'place':
                    $session->setPlace($param);
                    break;
                case 'description':
                    $session->setDescription($param);
                    break;
                case 'team':
                    $session->setTeam($param);
                    break;
                case 'pitch':
                    $session->setPitch($param);
                    break;
            }
        }

        return $session;
    }
}
