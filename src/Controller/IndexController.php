<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Game;
//use App\Entity\NewsType;
use App\Repository\GameRepository;
use App\Repository\NewsRepository;

class IndexController extends Controller
{
    /**
     * @param NewsRepository $newsRepository
     * @param GameRepository $gameRepository
     * @return Response
     */
    public function indexAction(NewsRepository $newsRepository, GameRepository $gameRepository)
    {
        $news = $newsRepository->findLatestNews();
        $pastGameRows = $gameRepository->findPastGames(null, 10);
        $futureGameRows = $gameRepository->findFutureGames(null, 10);

        $getGamesByDate = function ($gameRows) {
            $games = array();

            /** @var Game $game */
            foreach ($gameRows as $game) {
                $date = $game->getStartsOn()->format('D d.m.Y');

                if (array_key_exists($date, $games) === false) {
                    $games[$date] = array(
                        'starts_on' => $date,
                        'games' => array(),
                    );
                }

                $games[$date]['games'][] = $game;
            }

            return $games;
        };

        $pastGames = $getGamesByDate($pastGameRows);
        $futureGames = $getGamesByDate($futureGameRows);

        return $this->render(
            'index/index.html.twig',
            array(
                'news' => $news,
                'pastGames' => $pastGames,
                'futureGames' => $futureGames,
            )
        );
    }
}
