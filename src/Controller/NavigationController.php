<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\NavigationEntry;
use App\Repository\NavigationEntryRepository;

class NavigationController extends Controller
{
    /**
     * @param NavigationEntryRepository $navigationEntryRepository
     * @param Request $request
     * @return Response
     */
    public function indexAction(NavigationEntryRepository $navigationEntryRepository, Request $request)
    {
        $rows = $navigationEntryRepository->findBy(
            array(
                'parent' => null
            ),
            array(
                'sortIndex' => 'ASC',
            )
        );

        $requestStack = $this->container->get('request_stack');
        $masterRequest = $requestStack->getMasterRequest();
        $activeUrl = $masterRequest->getPathInfo();

        /**
         * @param NavigationEntry $item
         * @return array
         */
        $getItem = function ($item) use ($activeUrl, &$getItem) {
            $isActive = $item->getUrl() === $activeUrl;

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

        return $this->render(
            'navigation/index.html.twig',
            array(
                'entries' => $entries,
                'active' => $activeUrl,
            )
        );
    }
}
