<?php

declare(strict_types=1);

namespace Clubster\Bundle\CoreBundle\Menu;

use Clubster\Bundle\AdBundle\Security\Voter\AdVoter;
use Clubster\Bundle\CoreBundle\Menu\Event\MenuBuilderEvent;
use Clubster\Bundle\CoreBundle\Security\Voter\AdminUserVoter;
use Clubster\Bundle\CoreBundle\Security\Voter\LanguageVoter;
use Clubster\Bundle\MatchBundle\Security\Voter\MatchVoter;
use Clubster\Bundle\NewsBundle\Security\Voter\NewsVoter;
use Clubster\Bundle\PlayerBundle\Security\Voter\PlayerVoter;
use Clubster\Bundle\TeamBundle\Security\Voter\TeamVoter;
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
        $this->addAdsSubMenu($menu);
        $this->addMatchesSubMenu($menu);
        $this->addNewsSubMenu($menu);
        $this->addPlayersSubMenu($menu);
        $this->addTeamsSubMenu($menu);
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
    public function addAdsSubMenu(ItemInterface $menu): void
    {
        if ($this->authorizationChecker->isGranted(AdVoter::LIST)) {
            $items = $menu
                ->addChild('ads')
                ->setLabel('clubster.menu.admin.main_ads')
                ->setLabelAttribute('icon', 'fa fa-users');

            $items
                ->addChild('ads', ['route' => 'clubster_admin_ad_index'])
                ->setLabel('clubster.menu.admin.main_ads_ad')
                ->setExtra('routes', [
                    'clubster_admin_ad_index',
                    'clubster_admin_ad_create',
                    'clubster_admin_ad_update',
                ]);
        }
    }

    /**
     * @param ItemInterface $menu
     */
    public function addMatchesSubMenu(ItemInterface $menu): void
    {
        if ($this->authorizationChecker->isGranted(MatchVoter::LIST)) {
            $items = $menu
                ->addChild('matches')
                ->setLabel('clubster.menu.admin.main_matches')
                ->setLabelAttribute('icon', 'fa fa-users');

            $items
                ->addChild('ads', ['route' => 'clubster_admin_match_index'])
                ->setLabel('clubster.menu.admin.main_matches_match')
                ->setExtra('routes', [
                    'clubster_admin_match_index',
                    'clubster_admin_match_create',
                    'clubster_admin_match_update',
                ]);
        }
    }

    /**
     * @param ItemInterface $menu
     */
    public function addNewsSubMenu(ItemInterface $menu): void
    {
        if ($this->authorizationChecker->isGranted(NewsVoter::LIST)) {
            $items = $menu
                ->addChild('news')
                ->setLabel('clubster.menu.admin.main_news')
                ->setLabelAttribute('icon', 'fa fa-users');

            $items
                ->addChild('ads', ['route' => 'clubster_admin_news_index'])
                ->setLabel('clubster.menu.admin.main_news_news')
                ->setExtra('routes', [
                    'clubster_admin_news_index',
                    'clubster_admin_news_create',
                    'clubster_admin_news_update',
                ]);
        }
    }

    /**
     * @param ItemInterface $menu
     */
    public function addPlayersSubMenu(ItemInterface $menu): void
    {
        if ($this->authorizationChecker->isGranted(PlayerVoter::LIST)) {
            $items = $menu
                ->addChild('players')
                ->setLabel('clubster.menu.admin.main_players')
                ->setLabelAttribute('icon', 'fa fa-users');

            $items
                ->addChild('ads', ['route' => 'clubster_admin_player_index'])
                ->setLabel('clubster.menu.admin.main_players_player')
                ->setExtra('routes', [
                    'clubster_admin_player_index',
                    'clubster_admin_player_create',
                    'clubster_admin_player_update',
                ]);
        }
    }

    /**
     * @param ItemInterface $menu
     */
    public function addTeamsSubMenu(ItemInterface $menu): void
    {
        if ($this->authorizationChecker->isGranted(TeamVoter::LIST)) {
            $items = $menu
                ->addChild('ads')
                ->setLabel('clubster.menu.admin.main_teams')
                ->setLabelAttribute('icon', 'fa fa-users');

            $items
                ->addChild('ads', ['route' => 'clubster_admin_team_index'])
                ->setLabel('clubster.menu.admin.main_teams_team')
                ->setExtra('routes', [
                    'clubster_admin_team_index',
                    'clubster_admin_team_create',
                    'clubster_admin_team_update',
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
