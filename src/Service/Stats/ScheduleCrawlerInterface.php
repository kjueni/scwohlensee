<?php

namespace App\Service\Stats;

use DateTime;

use Symfony\Component\DomCrawler\Crawler;

interface ScheduleCrawlerInterface
{
    /**
     * @return Crawler
     */
    public function getNodes();

    /**
     * @param Crawler $gameNode
     * @param int $index
     * @return null|string
     */
    public function getType(Crawler $gameNode, int $index): ?string;

    /**
     * @param Crawler $gameNode
     * @return string
     */
    public function getHomeTeam(Crawler $gameNode): string;

    /**
     * @param Crawler $gameNode
     * @return string
     */
    public function getAwayTeam(Crawler $gameNode): string;

    /**
     * @param Crawler $gameNode
     * @return int|null
     */
    public function getHomeScore(Crawler $gameNode): ?int;

    /**
     * @param Crawler $gameNode
     * @return int|null
     */
    public function getAwayScore(Crawler $gameNode): ?int;

    /**
     * @param Crawler $gameNode
     * @return string|null
     */
    public function getGameUrl(Crawler $gameNode): ?string;

    /**
     * @param Crawler $gameNode
     * @return DateTime|null
     */
    public function getDate(Crawler $gameNode): ?DateTime;
}
