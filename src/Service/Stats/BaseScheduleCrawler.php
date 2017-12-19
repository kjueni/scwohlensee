<?php

namespace App\Service\Stats;

use Symfony\Component\DomCrawler\Crawler;

abstract class BaseScheduleCrawler Extends BaseCrawler implements
    ScheduleCrawlerInterface
{
    /**
     * @return array
     */
    public function crawl(): array
    {
        $games = array();

        /**
         * @param Crawler $gameNode
         * @return array
         */
        $getGames = function (Crawler $gameNode) use ($games): array {
            return $this->parseGame($gameNode);
        };

        $games = $this->getNodes()->each($getGames);

        return $games;
    }

    /**
     * @param Crawler $gameNode
     * @return array
     */
    protected function parseGame(Crawler $gameNode): array
    {
        die(var_dump($gameNode));
        $game = array(
            'type' => $this->getType($gameNode),
            'date' => $this->getDate($gameNode),
            'home_team' => $this->getHomeTeam($gameNode),
            'away_team' => $this->getAwayTeam($gameNode),
            'home_score' => $this->getHomeScore($gameNode),
            'away_score' => $this->getAwayScore($gameNode),
            'url' => $this->getGameUrl($gameNode),
        );

        return $game;
    }
}
