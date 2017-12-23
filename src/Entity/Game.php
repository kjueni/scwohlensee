<?php

namespace App\Entity;

use DateTime;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @ORM\Table(name="games")
 */
class Game implements
    EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $opponent;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime|null
     */
    protected $startsOn;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var boolean
     */
    protected $isAway;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     * @var integer|null
     */
    protected $homeScore;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     * @var integer|null
     */
    protected $awayScore;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @var string|null
     */
    protected $url;

    /**
     * Many Games have one GameType.
     *
     * @ORM\ManyToOne(targetEntity="GameType", inversedBy="games")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @var GameType
     */
    protected $type;

    /**
     * Many Games have one Team.
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="games")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * @var Team
     */
    protected $team;

    /**
     * @param array $params
     * @return Game
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'opponent',
            'starts_on',
            'is_away',
            'team',
            'type',
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $game = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'opponent':
                    $game->setOpponent($param);
                    break;
                case  'starts_on':
                    $game->setStartsOn($param);
                    break;
                case  'is_away':
                    $game->setIsAway($param);
                    break;
                case  'home_score':
                    $game->setHomeScore($param);
                    break;
                case  'away_score':
                    $game->setAwayScore($param);
                    break;
                case  'url':
                    $game->setUrl($param);
                    break;
                case  'team':
                    $game->setTeam($param);
                    break;
                case  'type':
                    $game->setType($param);
                    break;
            }
        }

        return $game;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOpponent(): string
    {
        return $this->opponent;
    }

    /**
     * @param string $opponent
     */
    public function setOpponent(string $opponent)
    {
        $this->opponent = $opponent;
    }

    /**
     * @return DateTime|null
     */
    public function getStartsOn(): ?DateTime
    {
        return $this->startsOn;
    }

    /**
     * @param DateTime|null $startsOn
     */
    public function setStartsOn(DateTime $startsOn = null)
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
    public function setIsAway(bool $isAway)
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
    public function setHomeScore(int $homeScore = null)
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
    public function setAwayScore($awayScore)
    {
        $this->awayScore = $awayScore;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url|null
     */
    public function setUrl(string $url = null)
    {
        $this->url = $url;
    }

    /**
     * @return GameType
     */
    public function getType(): GameType
    {
        return $this->type;
    }

    /**
     * @param GameType $type
     */
    public function setType(GameType $type)
    {
        $this->type = $type;
    }

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
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return bool
     */
    public function isPastGame(): bool
    {
        return new DateTime() > $this->getStartsOn();
    }

    /**
     * @return bool
     */
    public function hasScore(): bool
    {
        return $this->getHomeScore() !== null && $this->getAwayScore() !== null;
    }
}
