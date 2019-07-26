<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class Profile implements
    ResourceInterface
{
    use TimestampableTrait;

    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $firstName;

    /**
     * @var string|null
     */
    protected $lastName;

    /**
     * @var string|null
     */
    protected $phoneNumber;

    /**
     * @var string|null
     */
    protected $mobileNumber;

    /**
     * @var AdminUser|null
     */
    protected $user;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    /**
     * @param string|null $mobileNumber
     */
    public function setMobileNumber(?string $mobileNumber): void
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return AdminUser|null
     */
    public function getUser(): ?AdminUser
    {
        return $this->user;
    }

    /**
     * @param AdminUser|null $user
     */
    public function setUser(?AdminUser $user): void
    {
        $this->user = $user;
    }
}
