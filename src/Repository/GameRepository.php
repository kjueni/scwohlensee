<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Game;

class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @param array $params
     * @return Game
     * @throws \Exception if some required parameters are not provided
     */
    public function create(array $params)
    {
        $game = Game::fromArray($params);

        return $game;
    }

    /**
     * @param Game $game
     * @param array $params
     * @return Game
     */
    public function hydrate(Game $game, $params)
    {
        foreach ($params as $key => $param) {
            switch ($key) {
                case  'opponent':
                    $game->setOpponent($param);
                    break;
                case  'starts_on':
                    $game->setStartsOn($param);
                    break;
                case  'is_away':
                    $game->setIsAway($param);
                    break;
                case  'home_score':
                    $game->setHomeScore($param);
                    break;
                case  'away_score':
                    $game->setAwayScore($param);
                    break;
                case  'url':
                    $game->setUrl($param);
                    break;
                case  'team':
                    $game->setTeam($param);
                    break;
                case  'type':
                    $game->setType($param);
                    break;
            }
        }

        return $game;
    }
}
