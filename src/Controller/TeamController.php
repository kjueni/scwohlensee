<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Team;
use App\Repository\TeamRepository;

class TeamController extends Controller
{
    /**
     * @param string $url
     * @param TeamRepository $repository
     * @return Response
     */
    public function detailAction($url, TeamRepository $repository)
    {
        /** @var Team $team */
        $team = $repository->findOneBy(
            array(
                'url' => $url
            )
        );

        if (!$team) {
            throw $this->createNotFoundException(
                sprintf(
                    'No team found for url: "%s"',
                    $url
                )
            );
        }

        return $this->render(
            'team/detail.html.twig',
            array(
                'team' => $team,
            )
        );
    }
}
