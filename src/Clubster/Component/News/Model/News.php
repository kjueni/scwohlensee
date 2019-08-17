<?php

namespace Clubster\Component\News\Model;

use Doctrine\Common\Collections\Collection;

class News implements NewsInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $lead;

    /**
     * @var string|null
     */
    protected $text;

    /**
     * @var string|null
     */
    protected $pictureUrl;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var NewsType[]|Collection
     */
    protected $types;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
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
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getLead(): ?string
    {
        return $this->lead;
    }

    /**
     * @param null|string $lead
     */
    public function setLead(?string $lead): void
    {
        $this->lead = $lead;
    }

    /**
     * @return null|string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param null|string $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return null|string
     */
    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    /**
     * @param null|string $pictureUrl
     */
    public function setPictureUrl(?string $pictureUrl): void
    {
        $this->pictureUrl = $pictureUrl;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return NewsType[]|Collection
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param NewsType[]|Collection $types
     */
    public function setTypes($types): void
    {
        $this->types = $types;
    }
}