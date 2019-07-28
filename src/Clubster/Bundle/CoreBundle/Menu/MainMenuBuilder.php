<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Menu;

use Clubster\Bundle\CoreBundle\Menu\Event\MenuBuilderEvent;
use Clubster\Bundle\CoreBundle\Security\Voter\AdminUserVoter;
use Clubster\Bundle\CoreBundle\Security\Voter\LanguageVoter;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

final class MainMenuBuilder
{
    public const EVENT_NAME = 'clubster.menu.admin.main';

    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * @param FactoryInterface $factory
     * @param EventDispatcherInterface $eventDispatcher
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(
        FactoryInterface $factory,
        EventDispatcherInterface $eventDispatcher,
        AuthorizationChecker $authorizationChecker
    ) {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param array $options
     * @return ItemInterface
     */
    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $this->addDashboardSubMenu($menu);
        $this->addUsersSubMenu($menu);
        $this->addAdministrationSubMenu($menu);

        $this->eventDispatcher->dispatch(self::EVENT_NAME, new MenuBuilderEvent($this->factory, $menu));

        return $menu;
    }

    /**
     * @param ItemInterface $menu
     */
    public function addDashboardSubMenu(ItemInterface $menu): void
    {
        if ($this->authorizationChecker->isGranted(AdminUserVoter::LIST)) {
            $dashboard = $menu
                ->addChild('dashboard', [
                    'route' => 'clubster_admin_dashboard',
                ])
                ->setExtra('uris', [
                    '/'
                ])
                ->setLabel('clubster.menu.admin.main_dashboard')
                ->setLabelAttribute('icon', 'fa fa-home');
        }
    }

    /**
     * @param ItemInterface $menu
     */
    public function addUsersSubMenu(ItemInterface $menu): void
    {
        if ($this->authorizationChecker->isGranted(AdminUserVoter::LIST)) {
            $users = $menu
                ->addChild('users')
                ->setLabel('clubster.menu.admin.main_users')
                ->setLabelAttribute('icon', 'fa fa-users');

            $users
                ->addChild('users', ['route' => 'sylius_admin_admin_user_index'])
                ->setLabel('clubster.menu.admin.main_users_user')
                ->setExtra('routes', [
                    'sylius_admin_admin_user_index',
                    'sylius_admin_admin_user_create',
                    'sylius_admin_admin_user_update',
                ]);
        }
    }

    /**
     * @param ItemInterface $menu
     */
    public function addAdministrationSubMenu(ItemInterface $menu): void
    {
        if ($this->authorizationChecker->isGranted(LanguageVoter::LIST)) {
            $administration = $menu
                ->addChild('administration')
                ->setLabel('clubster.menu.admin.main_administration')
                ->setLabelAttribute('icon', 'fa fa-clipboard');
        }

        if ($this->authorizationChecker->isGranted(LanguageVoter::LIST)) {
            $administration
                ->addChild('languages', ['route' => 'clubster_admin_language_index'])
                ->setLabel('clubster.menu.admin.main_administration_languages')
                ->setExtra('routes', [
                    'clubster_admin_language_index',
                    'clubster_admin_language_create',
                    'clubster_admin_language_update',
                ]);
        }
    }
}
