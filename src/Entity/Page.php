<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @ORM\Table(name="pages")
 */
class Page implements
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
     * @ORM\Column(type="string", length=400, nullable=true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     * @var string
     */
    protected $text;

    /**
     * @param array $params
     * @return Page
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'title',
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $page = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'title':
                    $page->setTitle($param);
                    break;
                case  'description':
                    $page->setDescription($param);
                    break;
                case  'text':
                    $page->setText($param);
                    break;
            }
        }

        return $page;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
}
