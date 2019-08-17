<?php

namespace Clubster\Component\Player\Model;

use Sylius\Component\Resource\Model\TimestampableTrait;

class Player implements PlayerInterface
{
    use TimestampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int|null
     */
    protected $number;

    /**
     * @var \DateTimeInterface
     */
    protected $birthDate;

    /**
     * @var string|null
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
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     */
    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTimeInterface|null $birthDate
     */
    public function setBirthDate(?\DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return string|null
     */
    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    /**
     * @param string|null $pictureUrl
     */
    public function setPictureUrl(?string $pictureUrl): void
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