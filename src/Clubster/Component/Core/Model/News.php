<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Clubster\Component\News\Model\News as BaseNews;

class News extends BaseNews implements
    ResourceInterface
{
    /**
     * @var Team[]|null
     */
    protected $teams;

    /**
     * @return Team[]|null
     */
    public function getTeams(): ?array
    {
        return $this->teams;
    }

    /**
     * @param Team[]|null $teams
     */
    public function setTeams(?array $teams): void
    {
        $this->teams = $teams;
    }
}