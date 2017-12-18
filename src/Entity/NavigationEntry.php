<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NavigationEntryRepository")
 * @ORM\Table(name="navigation_entries")
 */
class NavigationEntry implements
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
     * @ORM\Column(type="string", length=100, nullable=true)
     * @var string
     */
    protected $url;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     * @var string
     */
    protected $sortIndex;

    /**
     * One NavigationEntry has Many NavigationEntry.
     * @ORM\OneToMany(targetEntity="NavigationEntry", mappedBy="parent")
     * @var NavigationEntry
     */
    protected $children;

    /**
     * Many NavigationEntry have One NavigationEntry.
     * @ORM\ManyToOne(targetEntity="NavigationEntry", inversedBy="children")
     * @@ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @var NavigationEntry
     */
    protected $parent;

    /**
     * @param array $params
     * @return NavigationEntry
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

        $entry = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'title':
                    $entry->setTitle($param);
                    break;
                case  'url':
                    $entry->setUrl($param);
                    break;
                case  'sort_index':
                    $entry->setSortIndex($param);
                    break;
                case  'parent':
                    $entry->setParent($param);
                    break;
            }
        }

        return $entry;
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getSortIndex(): string
    {
        return $this->sortIndex;
    }

    /**
     * @param string $sortIndex
     */
    public function setSortIndex(string $sortIndex)
    {
        $this->sortIndex = $sortIndex;
    }

    /**
     * @return NavigationEntry
     */
    public function getChildren(): NavigationEntry
    {
        return $this->children;
    }

    /**
     * @param NavigationEntry $children
     */
    public function setChildren(NavigationEntry $children)
    {
        $this->children = $children;
    }

    /**
     * @return NavigationEntry
     */
    public function getParent(): NavigationEntry
    {
        return $this->parent;
    }

    /**
     * @param NavigationEntry $parent
     */
    public function setParent(NavigationEntry $parent)
    {
        $this->parent = $parent;
    }
}
