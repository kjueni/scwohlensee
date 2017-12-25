<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 * @ORM\Table(name="files")
 */
class File implements
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
     * @ORM\Column(type="string", length=200)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=200)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $type;

    /**
     * @ORM\Column(type="integer", length=10)
     * @var int
     */
    protected $size;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $url;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     * @var int|null
     */
    protected $sortIndex;

    /**
     * Many Files have Many NavigationEntries.
     * @ORM\ManyToMany(targetEntity="NavigationEntry", inversedBy="files")
     * @ORM\JoinTable(name="navigation_entries_files")
     * @var NavigationEntry[]
     */
    protected $navigationEntries;

    /**
     * @param array $params
     * @return File
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'title',
            'name',
            'type',
            'size',
            'url',
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $file = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'title':
                    $file->setTitle($param);
                    break;
                case 'name':
                    $file->setName($param);
                    break;
                case 'type':
                    $file->setType($param);
                    break;
                case 'size':
                    $file->setSize($param);
                    break;
                case 'url':
                    $file->setUrl($param);
                    break;
                case 'navigation_entries':
                    $file->setNavigationEntries($param);
                    break;
                case 'sort_index':
                    $file->setSortIndex($param);
                    break;
            }
        }

        return $file;
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
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
     * @return int|null
     */
    public function getSortIndex(): ?int
    {
        return $this->sortIndex;
    }

    /**
     * @param int|null $sortIndex
     */
    public function setSortIndex(int $sortIndex = null)
    {
        $this->sortIndex = $sortIndex;
    }

    /**
     * @return NavigationEntry[]
     */
    public function getNavigationEntries(): array
    {
        return $this->navigationEntries;
    }

    /**
     * @param NavigationEntry[] $navigationEntries
     */
    public function setNavigationEntries(array $navigationEntries)
    {
        $this->navigationEntries = $navigationEntries;
    }
}
