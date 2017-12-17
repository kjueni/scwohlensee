<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Employee;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerPositionRepository")
 * @ORM\Table(name="player_positions")
 */
class PlayerPosition implements
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
     * @ORM\Column(type="integer", length=1000, nullable=true)
     * @var integer
     */
    protected $sortIndex;

    /**
     * One PlayerPosition has Many Players.
     * @ORM\OneToMany(targetEntity="PlayerPosition", mappedBy="position")
     */
    protected $players;

    /**
     * @param array $params
     * @return PlayerPosition
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'name',
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $position = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $position->setName($param);
                    break;

                case 'sort_index':
                    $position->setSortIndex($param);
                    break;
            }
        }

        return $position;
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
     * @return integer
     */
    public function getSortIndex()
    {
        return $this->sortIndex;
    }

    /**
     * @param integer $sortIndex
     */
    public function setSortIndex($sortIndex)
    {
        $this->sortIndex = $sortIndex;
    }
}
