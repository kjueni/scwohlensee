<?php

namespace Clubster\Component\Match\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;

class Match implements MatchInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $opponent;

    /**
     * @var \DateTimeInterface|null
     */
    protected $startsOn;

    /**
     * @var bool
     */
    protected $isAway = false;

    /**
     * @var integer|null
     */
    protected $homeScore;

    /**
     * @var integer|null
     */
    protected $awayScore;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var Competition|null
     */
    protected $competition;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getOpponent(): ?string
    {
        return $this->opponent;
    }

    /**
     * @param string|null $opponent
     */
    public function setOpponent(?string $opponent): void
    {
        $this->opponent = $opponent;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartsOn(): ?\DateTimeInterface
    {
        return $this->startsOn;
    }

    /**
     * @param \DateTimeInterface|null $startsOn
     */
    public function setStartsOn(?\DateTimeInterface $startsOn): void
    {
        $this->startsOn = $startsOn;
    }

    /**
     * @return bool
     */
    public function isAway(): bool
    {
        return $this->isAway;
    }

    /**
     * @param bool $isAway
     */
    public function setIsAway(bool $isAway): void
    {
        $this->isAway = $isAway;
    }

    /**
     * @return int|null
     */
    public function getHomeScore(): ?int
    {
        return $this->homeScore;
    }

    /**
     * @param int|null $homeScore
     */
    public function setHomeScore(?int $homeScore): void
    {
        $this->homeScore = $homeScore;
    }

    /**
     * @return int|null
     */
    public function getAwayScore(): ?int
    {
        return $this->awayScore;
    }

    /**
     * @param int|null $awayScore
     */
    public function setAwayScore(?int $awayScore): void
    {
        $this->awayScore = $awayScore;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return Competition|null
     */
    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    /**
     * @param Competition|null $competition
     */
    public function setCompetition(?Competition $competition): void
    {
        $this->competition = $competition;
    }
}