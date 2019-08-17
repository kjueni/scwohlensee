<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Clubster\Component\Match\Model\Match as BaseMatch;

class Match extends BaseMatch implements
    ResourceInterface
{
    /**
     * @var Team
     */
    protected $team;

    /**
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }
}