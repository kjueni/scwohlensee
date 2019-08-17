<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Clubster\Component\Team\Model\Team as BaseTeam;

class Team extends BaseTeam implements
    ResourceInterface
{
    /**
     * @var News[]
     */
    protected $news;

    /**
     * @var Player[]
     */
    protected $players;

    /**
     * @var Match[]
     */
    protected $matches;

    /**
     * @return News[]
     */
    public function getNews(): array
    {
        return $this->news;
    }

    /**
     * @param News[] $news
     */
    public function setNews(array $news): void
    {
        $this->news = $news;
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @param Player[] $players
     */
    public function setPlayers(array $players): void
    {
        $this->players = $players;
    }

    /**
     * @return Match[]
     */
    public function getMatches(): array
    {
        return $this->matches;
    }

    /**
     * @param Match[] $matches
     */
    public function setMatches(array $matches): void
    {
        $this->matches = $matches;
    }
}