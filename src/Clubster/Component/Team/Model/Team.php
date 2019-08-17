<?php

namespace Clubster\Component\Team\Model;

class Team implements TeamInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var string|null
     */
    protected $league;

    /**
     * @var string|null
     */
    protected $pictureUrl;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var string|null
     */
    protected $gamesUrl;

    /**
     * @var string|null
     */
    protected $resultsUrl;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return null|string
     */
    public function getLeague(): ?string
    {
        return $this->league;
    }

    /**
     * @param null|string $league
     */
    public function setLeague(?string $league): void
    {
        $this->league = $league;
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
     * @return null|string
     */
    public function getGamesUrl(): ?string
    {
        return $this->gamesUrl;
    }

    /**
     * @param null|string $gamesUrl
     */
    public function setGamesUrl(?string $gamesUrl): void
    {
        $this->gamesUrl = $gamesUrl;
    }

    /**
     * @return null|string
     */
    public function getResultsUrl(): ?string
    {
        return $this->resultsUrl;
    }

    /**
     * @param null|string $resultsUrl
     */
    public function setResultsUrl(?string $resultsUrl): void
    {
        $this->resultsUrl = $resultsUrl;
    }
}