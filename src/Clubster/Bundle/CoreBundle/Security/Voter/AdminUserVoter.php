<?php

namespace Clubster\Bundle\CoreBundle\Security\Voter;

use Clubster\Component\Core\Model\AdminUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AdminUserVoter extends Voter
{
    const
        CREATE = 'sylius.admin_user.create',
        EDIT = 'sylius.admin_user.update',
        DELETE = 'sylius.admin_user.delete',
        SHOW = 'sylius.admin_user.show',
        LIST = 'sylius.admin_user.index',
        IMPERSONATE = 'sylius.admin_user.impersonate',
        RESET = 'sylius.admin_user.reset';

    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * @param AccessDecisionManagerInterface $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array(
            $attribute,
            array(
                self::CREATE,
                self::EDIT,
                self::DELETE,
                self::SHOW,
                self::LIST,
                self::IMPERSONATE,
                self::RESET,
            )
        )) {
            return false;
        }

        if (!empty($subject) && !$subject instanceof AdminUser) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed|null $user
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $user, TokenInterface $token)
    {
        $currentUser = $token->getUser();

        if (!$currentUser instanceof AdminUser) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($this->decisionManager->decide($token, array(AdminUser::ROLE_USER))) {
            switch ($attribute) {
                case self::CREATE:
                    return $this->canCreateUser($token);
                    break;
                case self::EDIT:
                    return $this->canEditUser($token, $user);
                    break;
                case self::DELETE:
                    return $this->canDeleteUser($token, $user);
                    break;
                case self::SHOW:
                    return $this->canShowUser($token);
                    break;
                case self::LIST:
                    return $this->canListUsers($token);
                    break;
                case self::IMPERSONATE:
                    return $this->canImpersonate($token, $user);
                    break;
                case self::RESET:
                    return $this->canResetUser($token, $user);
                    break;
            }
        }

        return false;
    }

    /**
     * @param TokenInterface $token
     * @param AdminUser $user
     * @return bool
     */
    protected function canEditUser(TokenInterface $token, AdminUser $user)
    {
        /** @var AdminUser $currentUser */
        $currentUser = $token->getUser();

        return $this->decisionManager->decide($token, array(AdminUser::ROLE_ADMIN)) || $this->isOwnUser($user,
                $currentUser);
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canCreateUser(TokenInterface $token)
    {
        return $this->decisionManager->decide($token, array(AdminUser::ROLE_ADMIN));
    }

    /**
     * @param TokenInterface $token
     * @param AdminUser $user
     * @return bool
     */
    protected function canDeleteUser(TokenInterface $token, AdminUser $user)
    {
        /** @var AdminUser $currentUser */
        $currentUser = $token->getUser();

        return $this->decisionManager->decide($token, array(AdminUser::ROLE_ADMIN)) && !$this->isOwnUser($user,
                $currentUser);
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canShowUser(TokenInterface $token)
    {
        return $this->decisionManager->decide($token, array(AdminUser::ROLE_ADMIN));
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canListUsers(TokenInterface $token)
    {
        return $this->decisionManager->decide($token, array(AdminUser::ROLE_ADMIN));
    }

    /**
     * @param TokenInterface $token
     * @param AdminUser $user
     * @return bool
     */
    protected function canImpersonate(TokenInterface $token, AdminUser $user)
    {
        /** @var AdminUser $currentUser */
        $currentUser = $token->getUser();

        return $this->decisionManager->decide($token, array(AdminUser::ROLE_SUPERADMIN)) && !$this->isOwnUser($user,
                $currentUser) && $user->isAccountNonLocked();
    }

    /**
     * @param TokenInterface $token
     * @param AdminUser $user
     * @return bool
     */
    protected function canResetUser(TokenInterface $token, AdminUser $user)
    {
        return $this->canEditUser($token, $user);
    }

    /**
     * @param AdminUser $userToEdit
     * @param AdminUser $currentUser
     * @return bool
     */
    protected function isOwnUser(AdminUser $userToEdit, AdminUser $currentUser): bool
    {
        return $userToEdit->getId() === $currentUser->getId();
    }

}
