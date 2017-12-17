<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

//use App\Entity\NewsType;
use App\Repository\NewsRepository;

class DefaultController extends Controller
{
    /**
     * @param NewsRepository $newsRepository
     * @return Response
     */
    public function indexAction(NewsRepository $newsRepository)
    {
        $news = $newsRepository->findBy(
            array(),
            array(
                'id' => 'ASC',
            ),
            10
        );

        return $this->render(
            'index/index.html.twig',
            array(
                'news' => $news,
            )
        );
    }
}
