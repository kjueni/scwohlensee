<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $league;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $pictureUrl;

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
     * @param array $params
     * @return Team
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'name'
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

                case 'employees':
                    $team->setEmployees($param);
                    break;

                case 'players':
                    $team->setPlayers($param);
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
    public function getName()
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @param string $league
     */
    public function setLeague($league)
    {
        $this->league = $league;
    }

    /**
     * @return string
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * @param string $pictureUrl
     */
    public function setPictureUrl($pictureUrl)
    {
        $this->pictureUrl = $pictureUrl;
    }

    /**
     * @return Employee[]
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
     * @return Player[]
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
}
