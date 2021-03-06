<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\News;
use App\Repository\NewsRepository;

class NewsController extends Controller
{
    /**
     * @param string $id
     * @param NewsRepository $repository
     * @return Response
     */
    public function detailAction($url, NewsRepository $repository)
    {
        /** @var News $news */
        $news = $repository->findOneBy(
            array(
                'url' => $url
            )
        );

        if (!$news) {
            throw $this->createNotFoundException(
                sprintf(
                    'No news found for url: "%s"',
                    $url
                )
            );
        }

        return $this->render(
            'news/detail.html.twig',
            array(
                'news' => $news,
            )
        );
    }
}
