<?php

namespace Clubster\Bundle\CoreBundle\Security\Voter;

use Clubster\Component\Core\Model\AdminUser;
use Clubster\Component\Core\Model\Language;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class LanguageVoter extends Voter
{
    const
        CREATE = 'clubster.language.create',
        EDIT = 'clubster.language.update',
        DELETE = 'clubster.language.delete',
        LIST = 'clubster.language.index';

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
                self::LIST,
            )
        )) {
            return false;
        }

        if (!empty($subject) && !$subject instanceof Language) {
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

        if ($this->decisionManager->decide($token, array(AdminUser::ROLE_SUPERADMIN))) {
            switch ($attribute) {
                case self::CREATE:
                    return $this->canCreateLanguage($token);
                    break;
                case self::EDIT:
                    return $this->canEditLanguage($token);
                    break;
                case self::DELETE:
                    return $this->canDeleteLanguage($token);
                    break;
                case self::LIST:
                    return $this->canListLanguages($token);
                    break;
            }
        }

        return false;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canEditLanguage(TokenInterface $token)
    {
        return true;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canCreateLanguage(TokenInterface $token)
    {
        return true;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canDeleteLanguage(TokenInterface $token)
    {
        return false;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canListLanguages(TokenInterface $token)
    {
        return true;
    }
}
