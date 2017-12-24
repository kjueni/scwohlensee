<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingSessionRepository")
 * @ORM\Table(name="training_sessions")
 */
class TrainingSession implements
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
     * @ORM\Column(type="integer", length=2)
     * @var string
     */
    protected $weekday;

    /**
     * @ORM\Column(type="string", length=10)
     * @var string
     */
    protected $startsOn;

    /**
     * @ORM\Column(type="string", length=10)
     * @var string
     */
    protected $endsOn;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string|null
     */
    protected $place;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string|null
     */
    protected $description;

    /**
     * Many TrainingSession have one Team.
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="trainingSessions")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * @var Team|null
     */
    protected $team;

    /**
     * Many TrainingSession have one Pitch.
     *
     * @ORM\ManyToOne(targetEntity="Pitch", inversedBy="trainingSessions")
     * @ORM\JoinColumn(name="pitch_id", referencedColumnName="id")
     * @var Pitch|null
     */
    protected $pitch;

    /**
     * @param array $params
     * @return TrainingSession
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'weekday',
            'starts_on',
            'ends_on',
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $session = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'weekday':
                    $session->setWeekday($param);
                    break;
                case  'starts_on':
                    $session->setStartsOn($param);
                    break;
                case  'ends_on':
                    $session->setEndsOn($param);
                    break;
                case 'place':
                    $session->setPlace($param);
                    break;
                case 'description':
                    $session->setDescription($param);
                    break;
                case 'team':
                    $session->setTeam($param);
                    break;
                case 'pitch':
                    $session->setPitch($param);
                    break;
            }
        }

        return $session;
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
    public function getWeekday(): string
    {
        return $this->weekday;
    }

    /**
     * @param string $weekday
     */
    public function setWeekday(string $weekday)
    {
        $this->weekday = $weekday;
    }

    /**
     * @return string
     */
    public function getStartsOn(): string
    {
        return $this->startsOn;
    }

    /**
     * @param string $startsOn
     */
    public function setStartsOn(string $startsOn)
    {
        $this->startsOn = $startsOn;
    }

    /**
     * @return string
     */
    public function getEndsOn(): string
    {
        return $this->endsOn;
    }

    /**
     * @param string $endsOn
     */
    public function setEndsOn(string $endsOn)
    {
        $this->endsOn = $endsOn;
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param string|null $place
     */
    public function setPlace(string $place = null)
    {
        $this->place = $place;
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
    public function setDescription(string $description = null)
    {
        $this->description = $description;
    }

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
    public function setTeam(Team $team = null)
    {
        $this->team = $team;
    }

    /**
     * @return Pitch|null
     */
    public function getPitch(): ?Pitch
    {
        return $this->pitch;
    }

    /**
     * @param Pitch|null $pitch
     */
    public function setPitch(Pitch $pitch = null)
    {
        $this->pitch = $pitch;
    }
}
