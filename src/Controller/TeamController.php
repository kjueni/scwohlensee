<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

//use App\Entity\Team;
use App\Repository\TeamRepository;

class TeamController extends Controller
{
    /**
     * @param TeamRepository $repository
     * @return Response
     */
    public function indexAction(TeamRepository $repository)
    {
        $teams = $repository->findAll();

        return $this->render(
            'team/index.html.twig',
            array(
                'teams' => $teams,
            )
        );
    }

    /**
     * @param string $id
     * @param TeamRepository $repository
     * @return Response
     */
    public function detailAction($id, TeamRepository $repository)
    {
        $team = $repository->find($id);

        if (!$team) {
            throw $this->createNotFoundException(
                sprintf(
                    'No team found for id: "%s"',
                    $id
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
