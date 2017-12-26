<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\NewsType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 * @ORM\Table(name="news")
 */
class News implements
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
    protected $author;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     * @var string
     */
    protected $lead;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     * @var string
     */
    protected $text;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @var string
     */
    protected $pictureUrl;

    /**
     * @ORM\Column(type="string", length=100)
     * @var string
     */
    protected $url;

    /**
     * Many News have Many Types.
     * @ORM\ManyToMany(targetEntity="NewsType")
     * @ORM\JoinTable(name="news_news_types",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="type_id", referencedColumnName="id")}
     *      )
     * @var NewsType[]
     */
    protected $types;

    /**
     * @param array $params
     * @return News
     * @throws \Exception
     */
    public static function fromArray(array $params)
    {
        $requiredParams = array(
            'author',
            'title',
            'text',
            'url',
        );

        foreach ($requiredParams as $param) {
            if (array_key_exists($param, $params) !== true) {
                throw new \Exception(
                    sprintf('Required paramter "%s" was not provided', $param)
                );
            }
        }

        $news = new self();

        foreach ($params as $key => $param) {
            switch ($key) {
                case  'author':
                    $news->setAuthor($param);
                    break;
                case  'title':
                    $news->setTitle($param);
                    break;
                case  'lead':
                    $news->setLead($param);
                    break;
                case  'text':
                    $news->setText($param);
                    break;
                case 'picture_url':
                    $news->setPictureUrl($param);
                    break;
                case 'url':
                    $news->setUrl($param);
                    break;
                case 'types':
                    $news->setTypes($param);
                    break;
            }
        }

        return $news;
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
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param string $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
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
     * @return NewsType[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param NewsType[] $types
     */
    public function setTypes($types)
    {
        $this->types = $types;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
