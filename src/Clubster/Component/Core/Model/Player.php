<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Clubster\Component\Player\Model\Player as BasePlayer;

class Player extends BasePlayer implements
    ResourceInterface
{
    /**
     * @var Team|null
     */
    protected $team;

    /**
     * @return Team|null
     */
    public function getTeam(): ?Team
    {
        return $this->team;
    }

    /**
     * @param Team|null $team
     */
    public function setTeam(?Team $team): void
    {
        $this->team = $team;
    }

}