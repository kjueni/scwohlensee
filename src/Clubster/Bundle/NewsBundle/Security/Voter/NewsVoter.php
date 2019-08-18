<?php

namespace Clubster\Bundle\NewsBundle\Security\Voter;

use Clubster\Component\Core\Model\AdminUser;
use Clubster\Component\News\Model\News;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class NewsVoter extends Voter
{
    const
        CREATE = 'clubster.news.create',
        EDIT = 'clubster.news.update',
        DELETE = 'clubster.news.delete',
        LIST = 'clubster.news.index';

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

        if (!empty($subject) && !$subject instanceof News) {
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
                    return $this->canCreate($token);
                    break;
                case self::EDIT:
                    return $this->canEdit($token);
                    break;
                case self::DELETE:
                    return $this->canDelete($token);
                    break;
                case self::LIST:
                    return $this->canList($token);
                    break;
            }
        }

        return false;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canEdit(TokenInterface $token)
    {
        return true;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canCreate(TokenInterface $token)
    {
        return true;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canDelete(TokenInterface $token)
    {
        return false;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    protected function canList(TokenInterface $token)
    {
        return true;
    }
}
