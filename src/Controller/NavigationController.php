<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\NavigationEntryRepository;

class NavigationController extends Controller
{
    /**
     * @param NavigationEntryRepository $navigationEntryRepository
     * @return Response
     */
    public function indexAction(NavigationEntryRepository $navigationEntryRepository)
    {
        $entries = $navigationEntryRepository->findBy(
            array(
                'parent' => null
            ),
            array(
                'sortIndex' => 'ASC',
            )
        );

        return $this->render(
            'navigation/index.html.twig',
            array(
                'entries' => $entries,
            )
        );
    }
}
