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
     * @param TeamRepository $teamRepository
     * @return Response
     */
    public function detailAction($url, TeamRepository $teamRepository)
    {
        /** @var Team $team */
        $team = $teamRepository->findOneBy(
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

        $pastGames = array();
        $futureGames = array();

        foreach ($team->getGames() as $game) {
            if ($game->isPastGame()) {
                $pastGames[] = $game;
            } else {
                $futureGames[] = $game;
            }
        }

        return $this->render(
            'team/detail.html.twig',
            array(
                'team' => $team,
                'pastGames' => $pastGames,
                'futureGames' => $futureGames,
            )
        );
    }
}
