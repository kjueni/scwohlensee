<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $number = mt_rand(0, 100);

        return $this->render(
            'index/index.html.twig',
            array(
                'number' => $number,
            )
        );
    }
}
