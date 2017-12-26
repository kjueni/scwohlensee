<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Game;
use App\Entity\Team;

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

    /**
     * @param Team|null $team
     * @param int|null $limit
     * @param int|null $offset
     * @return Game[]
     */
    public function findPastGames(Team $team = null, int $limit = null, int $offset = null): array
    {
        $queryBuilder = $this->prepareQueryBuilder($team, $limit, $offset);

        $queryBuilder->where(
            $queryBuilder->expr()->isNotNull("g.homeScore")
        );
        $queryBuilder->orderBy('g.startsOn', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Team|null $team
     * @param int|null $limit
     * @param int|null $offset
     * @return Game[]
     */
    public function findFutureGames(Team $team = null, int $limit = null, int $offset = null): array
    {
        $queryBuilder = $this->prepareQueryBuilder($team, $limit, $offset);

        $queryBuilder->where(
            $queryBuilder->expr()->isNull("g.homeScore")
        );
        $queryBuilder->orderBy('g.startsOn', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Team|null $team
     * @param int|null $limit
     * @param int|null $offset
     * @return QueryBuilder
     */
    protected function prepareQueryBuilder(Team $team = null, int $limit = null, int $offset = null): QueryBuilder
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder->select("g")->from(Game::Class, 'g');

        if ($team !== null) {
            $queryBuilder->where(
                array(
                    'team' => $team,
                )
            );
        }

        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        if ($offset !== null) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder;
    }
}
