<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoxRepository")
 * @ORM\Table(name="boxes")
 */
class Box implements
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
    protected $title;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     * @var string|null
     */
    protected $text;

    /**
     * @param array $params
     * @return Box
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'title'
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $box = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'title':
                    $box->setTitle($param);
                    break;
                case 'text':
                    $box->setText($param);
                    break;
            }
        }

        return $box;
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(string $text = null)
    {
        $this->text = $text;
    }
}
