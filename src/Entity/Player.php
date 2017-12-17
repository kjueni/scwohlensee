<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @ORM\Table(name="players")
 */
class Player implements
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
     * @ORM\Column(type="integer", length=10, nullable=true)
     * @var integer
     */
    protected $number;

    /**
     * @ORM\Column(type="date", length=40, nullable=true)
     * @var string
     */
    protected $birthDate;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $pictureUrl;

    /**
     * One Player has one PlayerPosition.
     *
     * @ORM\ManyToOne(targetEntity="PlayerPosition", inversedBy="players")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @var PlayerPosition|null
     */
    protected $position;

    /**
     * @param array $params
     * @return Player
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

        $player = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $player->setName($param);
                    break;
                case  'number':
                    $player->setNumber($param);
                    break;
                case  'birthDate':
                    $player->setBirthDate($param);
                    break;
                case 'picture_url':
                    $player->setPictureUrl($param);
                    break;
                case 'position':
                    $player->setPosition($param);
                    break;
            }
        }

        return $player;
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
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
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
     * @return PlayerPosition|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param PlayerPosition|null $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
