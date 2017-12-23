<?php

namespace App\Service\Stats;

use DateTime;

use Symfony\Component\DomCrawler\Crawler;

class SFVScheduleCrawler extends BaseScheduleCrawler
{
    protected $typeMapping = array();

    /**
     * @return array|Crawler
     */
    public function getNodes()
    {
        $allNodes = $this->getCrawler()->evaluate('//div[contains(@class, "list-group-item")]');
        $lastType = null;
        $index = 0;

        /**
         * @param Crawler $node
         * @return Crawler|null
         */
        $getNode = function ($node) use (&$lastType, &$index): ?Crawler {
            if (strpos($node->attr('class'), 'sppTitel') !== false) {
                $lastType = trim(
                    $node->text()
                );
            } elseif ($node->children()->filterXPath('//div[contains(@class, "spiel")]')->count()) {
                $this->addToMapping($index, $lastType);
                $index++;
                return $node;
            }

            return null;
        };

        /** @var Crawler[] $gameNodes */
        $gameNodes = array_filter(
            $allNodes->each($getNode),
            function ($value) {
                return $value !== null;
            }
        );

        return $gameNodes;
    }

    /**
     * @param int $index
     * @param string $lastType
     */
    protected function addToMapping(int $index, string $lastType)
    {
        $this->typeMapping[$index] = $lastType;
    }

    /**
     * @param int $index
     * @return string
     */
    protected function getMappedType(int $index): string
    {
        return $this->typeMapping[$index];
    }

    /**
     * @param Crawler $gameNode
     * @param int $index
     * @return null|string
     */
    public function getType(Crawler $gameNode, int $index): ?string
    {
        return $this->getMappedType($index);
    }

    /**
     * @param Crawler $gameNode
     * @return string
     */
    public function getHomeTeam(Crawler $gameNode): string
    {
        return trim(
            $gameNode->filterXPath('//div[contains(@class, "teams")]/div[contains(@class, "teamA")]')->text()
        );
    }

    /**
     * @param Crawler $gameNode
     * @return string
     */
    public function getAwayTeam(Crawler $gameNode): string
    {
        return trim(
            $gameNode->filterXPath('//div[contains(@class, "teams")]/div[contains(@class, "teamB")]')->text()
        );
    }

    /**
     * @param Crawler $gameNode
     * @return integer|null
     */
    public function getHomeScore(Crawler $gameNode): ?int
    {

        $node = $gameNode->filterXPath('//div[contains(@class, "goals")]/div[contains(@class, "torA")]');

        if ($node && $node->count()) {
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
        $node = $gameNode->filterXPath('//div[contains(@class, "goals")]/div[contains(@class, "torB")]');

        if ($node && $node->count()) {
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
        $node = $gameNode->filterXPath('//div[contains(@class, "telegramm-link")]/a');

        if ($node && $node->count() && $node->attr('href') && $this->getAwayScore($gameNode) !== null) {
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
        $node = $gameNode->filterXPath('//div[contains(@class, "date")]');

        if ($node) {
            $dateTimeString = trim(
                $node->text()
            );

            $dateString = substr($dateTimeString, 3, 10);
            $timeString = substr($dateTimeString, 13, strlen($dateTimeString));

            $date = DateTime::createFromFormat(
                'd.m.Y H:i',
                $dateString . ' ' . ($timeString ? $timeString : '00:00')
            );

            if ($date) {
                return $date;
            }
        }

        return null;
    }
}
