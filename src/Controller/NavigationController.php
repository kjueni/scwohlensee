<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
        $entries = $navigationEntryRepository->findBy(
            array(
                'parent' => null
            ),
            array(
                'sortIndex' => 'ASC',
            )
        );

        $requestStack = $this->container->get('request_stack');
        $masterRequest = $requestStack->getMasterRequest();

        return $this->render(
            'navigation/index.html.twig',
            array(
                'entries' => $entries,
                'active' => $masterRequest->getPathInfo(),
            )
        );
    }
}
