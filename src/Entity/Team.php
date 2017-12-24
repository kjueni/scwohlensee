<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @ORM\Table(name="teams")
 */
class Team implements
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
    protected $name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     * @var string|null
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string|null
     */
    protected $league;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string|null
     */
    protected $pictureUrl;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string|null
     */
    protected $url;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @var string|null
     */
    protected $gamesUrl;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @var string|null
     */
    protected $resultsUrl;

    /**
     * Many Teams have Many Employees.
     *
     * @ORM\ManyToMany(targetEntity="Employee")
     * @ORM\JoinTable(name="teams_employees",
     *      joinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")}
     *      )
     * @var Employee[]
     */
    protected $employees;

    /**
     * Many Teams have Many Players.
     *
     * @ORM\ManyToMany(targetEntity="Player")
     * @ORM\JoinTable(name="teams_players",
     *      joinColumns={@ORM\JoinColumn(name="team_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")}
     *      )
     * @var Player[]
     */
    protected $players;

    /**
     * One Team has many Games.
     *
     * @ORM\OneToMany(targetEntity="Game", mappedBy="team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * @var Game[]
     */
    protected $games;

    /**
     * One Team has many TrainingSessions.
     *
     * @ORM\OneToMany(targetEntity="TrainingSession", mappedBy="team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * @var TrainingSession[]
     */
    protected $trainingSessions;

    /**
     * @param array $params
     * @return Team
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'name',
            'url'
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $team = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $team->setName($param);
                    break;
                case 'description':
                    $team->setDescription($param);
                    break;
                case 'league':
                    $team->setLeague($param);
                    break;
                case 'picture_url':
                    $team->setPictureUrl($param);
                    break;
                case 'url':
                    $team->setUrl($param);
                    break;
                case 'games_url':
                    $team->setGamesUrl($param);
                    break;
                case 'results_url':
                    $team->setResultsUrl($param);
                    break;
                case 'employees':
                    $team->setEmployees($param);
                    break;
                case 'players':
                    $team->setPlayers($param);
                    break;
                case 'games':
                    $team->setGames($param);
                    break;
            }
        }

        return $team;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription($description = null)
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getLeague(): ?string
    {
        return $this->league;
    }

    /**
     * @param string|null $league
     */
    public function setLeague($league = null)
    {
        $this->league = $league;
    }

    /**
     * @return string|null
     */
    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    /**
     * @param string|null $pictureUrl
     */
    public function setPictureUrl($pictureUrl = null)
    {
        $this->pictureUrl = $pictureUrl;
    }

    /**
     * @return Employee[]|PersistentCollection
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * @param Employee[] $employees
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;
    }

    /**
     * @return Player[]|PersistentCollection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param Player[] $players
     */
    public function setPlayers($players)
    {
        $this->players = $players;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getGamesUrl(): ?string
    {
        return $this->gamesUrl;
    }

    /**
     * @param string|null $gamesUrl
     */
    public function setGamesUrl(string $gamesUrl = null)
    {
        $this->gamesUrl = $gamesUrl;
    }

    /**
     * @return string|null
     */
    public function getResultsUrl(): ?string
    {
        return $this->resultsUrl;
    }

    /**
     * @param string|null $resultsUrl
     */
    public function setResultsUrl(string $resultsUrl = null)
    {
        $this->resultsUrl = $resultsUrl;
    }

    /**
     * @return Game[]|PersistentCollection
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param Game[] $games
     */
    public function setGames(array $games)
    {
        $this->games = $games;
    }

    /**
     * @return TrainingSession[]
     */
    public function getTrainingSessions(): array
    {
        return $this->trainingSessions;
    }
}
