<?php

namespace Clubster\Bundle\CoreBundle\Security\Voter;

use Clubster\Component\Core\Model\AdminUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProfileVoter extends Voter
{
    const
        EDIT = 'clubster.profile.update';

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
                self::EDIT,
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
                case self::EDIT:
                    return $this->canEditProfile($token, $user);
                    break;
            }
        }

        return false;
    }

    /**
     * @param TokenInterface $token
     * @param AdminUser|null $user
     * @return bool
     */
    protected function canEditProfile(TokenInterface $token, ?AdminUser $user)
    {
        /** @var AdminUser $currentUser */
        $currentUser = $token->getUser();

        return $this->isOwnUser($user,
            $currentUser);
    }

    /**
     * @param AdminUser|null $userToEdit
     * @param AdminUser $currentUser
     * @return bool
     */
    protected function isOwnUser(?AdminUser $userToEdit, AdminUser $currentUser): bool
    {
        return $userToEdit && $userToEdit->getId() === $currentUser->getId();
    }

}
