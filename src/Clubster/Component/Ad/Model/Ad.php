<?php

namespace Clubster\Component\Ad\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class Ad implements
    AdInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var string|null
     */
    protected $address;

    /**
     * @var string|null
     */
    protected $pictureUrl;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var AdType[]|Collection
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
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
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
     * @return AdType[]|Collection
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param AdType[]|Collection $types
     */
    public function setTypes($types): void
    {
        $this->types = $types;
    }
}