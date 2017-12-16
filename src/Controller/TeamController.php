<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Team;

class TeamController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $teams = $this->getDoctrine()
            ->getRepository(Team::class)
            ->findAll();

        return $this->render(
            'team/index.html.twig',
            array(
                'teams' => $teams,
            )
        );
    }

    /**
     * @param string $id
     * @return Response
     */
    public function showAction($id)
    {
        $team = $this->getDoctrine()
            ->getRepository(Team::class)
            ->find($id);

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

    /**
     * @return RedirectResponse
     */
    public function createAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $teamRepository = $entityManager->getRepository(Team::class);

        $team = $teamRepository->create(
            array(
                'name' => '1. Mannschaft',
                'description' => 'Beschreibung 1. Mannschaft',
                'league' => '3. Liga',
            )
        );

        $entityManager->persist($team);
        $entityManager->flush();

        return $this->redirectToRoute(
            'team-show',
            array(
                'id' => $team->getId(),
            )
        );
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function updateAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $teamRepository = $entityManager->getRepository(Team::class);
        $team = $teamRepository->find($id);

        if (!$team) {
            throw $this->createNotFoundException(
                sprintf(
                    'No team found for id: "%s"',
                    $id
                )
            );
        }

        $team = $teamRepository->hydrate(
            $team,
            array(
                'name' => '2. Mannschaft',
            )
        );

        $entityManager->persist($team);
        $entityManager->flush();

        return $this->redirectToRoute(
            'team-show',
            array(
                'id' => $team->getId(),
            )
        );
    }
}
