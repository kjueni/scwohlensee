<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Page;
use App\Repository\PageRepository;

class PageController extends Controller
{
    /**
     * @param string $url
     * @param PageRepository $repository
     * @return Response
     */
    public function detailAction($url, PageRepository $repository)
    {
        /** @var Page $page */
        $page = $repository->findOneBy(
            array(
                'url' => $url
            )
        );

        if (!$page) {
            throw $this->createNotFoundException(
                sprintf(
                    'No page found for url: "%s"',
                    $url
                )
            );
        }

        return $this->render(
            'page/detail.html.twig',
            array(
                'page' => $page,
            )
        );
    }
}
