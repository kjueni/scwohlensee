<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PitchRepository")
 * @ORM\Table(name="pitches")
 */
class Pitch implements
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
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(type="integer", length=4, nullable=true)
     * @var integer
     */
    protected $zipCode;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $place;

    /**
     * One Pitch has many TrainingSessions.
     *
     * @ORM\OneToMany(targetEntity="TrainingSession", mappedBy="pitch")
     * @ORM\JoinColumn(name="pitch_id", referencedColumnName="id")
     * @var TrainingSession[]
     */
    protected $trainingSessions;

    /**
     * @param array $params
     * @return Pitch
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

        $pitch = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'name':
                    $pitch->setName($param);
                    break;
                case  'address':
                    $pitch->setAddress($param);
                    break;
                case  'zip_code':
                    $pitch->setZipCode($param);
                    break;
                case  'place':
                    $pitch->setPlace($param);
                    break;
            }
        }

        return $pitch;
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
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(string $address = null)
    {
        $this->address = $address;
    }

    /**
     * @return int|null
     */
    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    /**
     * @param int|null $zipCode
     */
    public function setZipCode(int $zipCode = null)
    {
        $this->zipCode = $zipCode;
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
     * @return TrainingSession[]
     */
    public function getTrainingSessions(): array
    {
        return $this->trainingSessions;
    }
}
