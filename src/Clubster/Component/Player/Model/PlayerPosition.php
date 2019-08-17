<?php

namespace Clubster\Component\Player\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;

class PlayerPosition implements PlayerPositionInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $sortIndex;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getSortIndex(): int
    {
        return $this->sortIndex;
    }

    /**
     * @param int $sortIndex
     */
    public function setSortIndex(int $sortIndex): void
    {
        $this->sortIndex = $sortIndex;
    }
}