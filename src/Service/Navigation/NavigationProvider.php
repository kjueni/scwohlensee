<?php

namespace App\Service\Navigation;

use Symfony\Component\HttpFoundation\RequestStack;

use App\Entity\NavigationEntry;
use App\Repository\NavigationEntryRepository;

class NavigationProvider
{
    /**
     * @var array
     */
    protected $entries;

    /**
     * @var NavigationEntry
     */
    protected $activeItem;

    /**
     * NavigationProvider constructor.
     * @param NavigationEntryRepository $navigationEntryRepository
     * @param RequestStack $requestStack
     */
    public function __construct(NavigationEntryRepository $navigationEntryRepository, RequestStack $requestStack)
    {
        $this->loadItems(
            $navigationEntryRepository,
            $requestStack->getMasterRequest()->getPathInfo()
        );
    }

    /**
     * @param NavigationEntryRepository $navigationEntryRepository
     * @param string $activePath
     */
    public function loadItems(NavigationEntryRepository $navigationEntryRepository, string $activePath)
    {
        $rows = $navigationEntryRepository->findBy(
            array(
                'parent' => null
            ),
            array(
                'sortIndex' => 'ASC',
            )
        );

        $activeItem = null;

        /**
         * @param NavigationEntry $item
         * @return array
         */
        $getItem = function ($item) use ($activePath, &$getItem, &$activeItem) {
            $isActive = $item->getUrl() === $activePath;

            if ($isActive === true) {
                $activeItem = $item;
            }

            $itemData = array(
                'title' => $item->getTitle(),
                'url' => $item->getUrl(),
                'active' => null,
            );

            $children = $item->getChildren();

            if (count($children)) {
                $itemData['children'] = array();

                foreach ($children as $child) {
                    $childData = $getItem($child);

                    if ($childData['active'] === true) {
                        $isActive = true;
                    }

                    $itemData['children'][] = $childData;
                }
            }

            $itemData['active'] = $isActive;

            return $itemData;
        };

        $entries = array();

        foreach ($rows as $row) {
            $entries[] = $getItem($row);
        }

        $this->setEntries($entries);
        $this->setActiveItem($activeItem);
    }

    /**
     * @return NavigationEntry
     */
    public function getActiveItem(): NavigationEntry
    {
        return $this->activeItem;
    }

    /**
     * @param NavigationEntry $activeItem
     */
    public function setActiveItem(NavigationEntry $activeItem)
    {
        $this->activeItem = $activeItem;
    }

    /**
     * @return array
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * @param array $entries
     */
    public function setEntries(array $entries)
    {
        $this->entries = $entries;
    }
}
