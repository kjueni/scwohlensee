<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdTypeRepository")
 * @ORM\Table(name="ad_types")
 */
class AdType implements
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
     * @var int|null
     */
    protected $showCount;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     * @var int|null
     */
    protected $width;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     * @var int|null
     */
    protected $height;

    /**
     * @param array $params
     * @return AdType
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
                case  'show_count':
                    $type->setShowCount($param);
                    break;
                case 'width':
                    $type->setWidth($param);
                    break;
                case 'height':
                    $type->setHeight($param);
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

    /**
     * @return int|null
     */
    public function getShowCount(): ?int
    {
        return $this->showCount;
    }

    /**
     * @param int|null $showCount
     */
    public function setShowCount(int $showCount = null)
    {
        $this->showCount = $showCount;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     */
    public function setWidth(int $width = null)
    {
        $this->width = $width;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     */
    public function setHeight(int $height = null)
    {
        $this->height = $height;
    }
}
