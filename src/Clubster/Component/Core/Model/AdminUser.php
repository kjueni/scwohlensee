<?php

declare(strict_types=1);

namespace Clubster\Component\Core\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\User\Model\User;

class AdminUser extends User implements
    ResourceInterface
{
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';

    /**
     * @var string|null
     */
    protected $password;

    /**
     * @var bool
     */
    protected $smsAuthentication = false;

    /**
     * @var int|null
     */
    protected $loginCount = 0;

    /**
     * @var int|null
     */
    protected $failedLogins = 0;

    /**
     * @var Profile
     */
    protected $profile;

    /**
     * @var Language|null
     */
    protected $language;

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function hasSmsAuthentication(): bool
    {
        return $this->smsAuthentication;
    }

    /**
     * @param bool|null $smsAuthentication
     */
    public function setSmsAuthentication(?bool $smsAuthentication = false): void
    {
        $this->smsAuthentication = $smsAuthentication;
    }

    /**
     * @return int|null
     */
    public function getLoginCount(): ?int
    {
        return $this->loginCount;
    }

    /**
     * @param int $loginCount
     */
    public function setLoginCount(int $loginCount = 0): void
    {
        $this->loginCount = $loginCount;
    }

    /**
     * @return int|null
     */
    public function getFailedLogins(): ?int
    {
        return $this->failedLogins;
    }

    /**
     * @param int $failedLogins
     */
    public function setFailedLogins(int $failedLogins = 0): void
    {
        $this->failedLogins = $failedLogins;
    }

    /**
     * @return Language|null
     */
    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    /**
     * @param Language|null $language
     */
    public function setLanguage(?Language $language): void
    {
        $this->language = $language;
    }

    /**
     * @return Profile|null
     */
    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    /**
     * @param Profile $profile
     */
    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return array_unique(array_merge($this->roles, [
            self::DEFAULT_ROLE,
        ]));
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles = []): void
    {
        $this->roles = $roles;
    }
}
