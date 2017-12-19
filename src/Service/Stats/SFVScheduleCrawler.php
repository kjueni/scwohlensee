<?php

namespace App\Service\Stats;

use DateTime;

use Symfony\Component\DomCrawler\Crawler;

class SFVScheduleCrawler extends BaseScheduleCrawler
{
    /**
     * @return array|Crawler
     */
    public function getNodes(): Crawler
    {
        return $this->getCrawler()->evaluate('//div[contains(@class, "spiel")]');
    }

    /**
     * @param Crawler $node
     * @return string|null
     */
    public function getType(Crawler $gameNode): ?string
    {
        $type = $gameNode->parents()->previousAll();

        if ($type && strpos($type->attr('class'), 'sppTitel') !== false) {
            return trim($type->text());
        }

        return null;
    }

    /**
     * @param Crawler $gameNode
     * @return string
     */
    public function getHomeTeam(Crawler $gameNode): string
    {
        return trim(
            $gameNode->evaluate('//div[contains(@class, "teams")]/div[contains(@class, "teamA")]')->text()
        );
    }

    /**
     * @param Crawler $gameNode
     * @return string
     */
    public function getAwayTeam(Crawler $gameNode): string
    {
        return trim(
            $gameNode->evaluate('//div[contains(@class, "teams")]/div[contains(@class, "teamB")]')->text()
        );
    }

    /**
     * @param Crawler $gameNode
     * @return integer|null
     */
    public function getHomeScore(Crawler $gameNode): ?int
    {

        $node = $gameNode->evaluate('//div[contains(@class, "goals")]/div[contains(@class, "torA")]');

        if ($node) {
            return intval(
                trim(
                    $node->text()
                )
            );
        }

        return null;
    }

    /**
     * @param Crawler $gameNode
     * @return int|null
     */
    public function getAwayScore(Crawler $gameNode): ?int
    {

        $node = $gameNode->evaluate('//div[contains(@class, "goals")]/div[contains(@class, "torB")]');

        if ($node) {
            return intval(
                trim(
                    $node->text()
                )
            );
        }

        return null;
    }

    /**
     * @param Crawler $gameNode
     * @return string|null
     */
    public function getGameUrl(Crawler $gameNode): ?string
    {
        $node = $gameNode->evaluate('//div[contains(@class, "telegramm-link")]/a');

        if ($node && $node->attr('href')) {
            return $gameNode->getBaseHref() . $node->attr('href');
        }

        return null;
    }

    /**
     * @param Crawler $gameNode
     * @return DateTime|null
     */
    public function getDate(Crawler $gameNode): ?DateTime
    {
        $node = $gameNode->evaluate('//div[contains(@class, "date")]');

        if ($node) {
            $dateString = trim(
                $node->text()
            );

            $date = DateTime::createFromFormat('d.m.YH:i', substr($dateString, 3, strlen($dateString)));

            if ($date) {
                return $date;
            }
        }

        return null;
    }
}
