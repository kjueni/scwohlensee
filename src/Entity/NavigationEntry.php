<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

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
     * @var integer
     */
    protected $sortIndex;

    /**
     * One NavigationEntry has Many NavigationEntry.
     * @ORM\OneToMany(targetEntity="NavigationEntry", mappedBy="parent")
     * @var NavigationEntry[]|PersistentCollection
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
     * Many NavigationEntries have Many Boxes.
     * @ORM\ManyToMany(targetEntity="Box")
     * @ORM\JoinTable(name="navigation_entries_boxes",
     *      joinColumns={@ORM\JoinColumn(name="box_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="entry_id", referencedColumnName="id")}
     *      )
     * @var Box[]
     */
    protected $boxes;

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
                case  'boxes':
                    $entry->setBoxes($param);
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
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl($url = null)
    {
        $this->url = $url;
    }

    /**
     * @return integer|null
     */
    public function getSortIndex()
    {
        return $this->sortIndex;
    }

    /**
     * @param integer|null $sortIndex
     */
    public function setSortIndex($sortIndex = null)
    {
        $this->sortIndex = $sortIndex;
    }

    /**
     * @return NavigationEntry|PersistentCollection|null
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param NavigationEntry|PersistentCollection|null $children
     */
    public function setChildren($children)
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

    /**
     * @return Box[]
     */
    public function getBoxes(): array
    {
        return $this->boxes;
    }

    /**
     * @param Box[] $boxes
     */
    public function setBoxes(array $boxes)
    {
        $this->boxes = $boxes;
    }
}
