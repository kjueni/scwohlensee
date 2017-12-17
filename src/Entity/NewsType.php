<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\News;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsTypeRepository")
 * @ORM\Table(name="news_types")
 */
class NewsType implements
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
     * @param array $params
     * @return NewsType
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
}
