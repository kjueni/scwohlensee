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
         * @param int $index
         * @return array
         */
        $getGames = function (Crawler $gameNode, int $index): array {
            return $this->parseGame($gameNode, $index);
        };

        /** @var Crawler|array $nodes */
        $nodes = $this->getNodes();

        if ($nodes instanceof Crawler) {
            $games = $this->getNodes()->each($getGames);
        } elseif (is_array($nodes)) {
            $index = 0;
            foreach ($nodes as $node) {
                $games[] = $getGames($node, $index);
                $index++;
            }
        }

        return $games;
    }

    /**
     * @param Crawler $gameNode
     * @param int $index
     * @return array
     */
    protected function parseGame(Crawler $gameNode, int $index): array
    {
        $game = array(
            'type' => $this->getType($gameNode, $index),
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
