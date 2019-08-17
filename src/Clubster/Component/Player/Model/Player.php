<?php

namespace Clubster\Component\Player\Model;

class Player implements PlayerInterface
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
     * @var integer
     */
    protected $number;

    /**
     * @var string
     */
    protected $birthDate;

    /**
     * @var string
     */
    protected $pictureUrl;

    /**
     * @var PlayerPosition|null
     */
    protected $position;

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
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate(string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getPictureUrl(): string
    {
        return $this->pictureUrl;
    }

    /**
     * @param string $pictureUrl
     */
    public function setPictureUrl(string $pictureUrl): void
    {
        $this->pictureUrl = $pictureUrl;
    }

    /**
     * @return PlayerPosition|null
     */
    public function getPosition(): ?PlayerPosition
    {
        return $this->position;
    }

    /**
     * @param PlayerPosition|null $position
     */
    public function setPosition(?PlayerPosition $position): void
    {
        $this->position = $position;
    }
}