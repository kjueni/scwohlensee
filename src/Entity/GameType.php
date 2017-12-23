<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameTypeRepository")
 * @ORM\Table(name="game_types")
 */
class GameType implements
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
     * One GameType has many Games.
     *
     * @ORM\OneToMany(targetEntity="Game", mappedBy="type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @var Game[]
     */
    protected $games;

    /**
     * @param array $params
     * @return GameType
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

        $type = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $type->setName($param);
                    break;
            }
        }

        return $type;
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
    public function setName(string $name)
    {
        $this->name = $name;
    }
}
